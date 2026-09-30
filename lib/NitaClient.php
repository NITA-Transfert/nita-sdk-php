<?php

/**
 * NitaClient
 *
 * Couche mince écrite à la main (NON générée par openapi-generator) --
 * protégée de la régénération via .openapi-generator-ignore.
 *
 * @package Nita\Sdk
 */

namespace Nita\Sdk;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use Nita\Sdk\Api\AchatEnLigneV2Api;
use Nita\Sdk\Api\CheckingV2Api;
use Nita\Sdk\Api\CompteV2Api;
use Nita\Sdk\Api\LocalitsV2Api;
use Nita\Sdk\Api\MyNitaV2Api;
use Nita\Sdk\Api\EnvoiInterPartenaireV2Api;
use Nita\Sdk\Api\TransactionsV2Api;
use Nita\Sdk\Model\ModelInterface;

/**
 * Couche mince ergonomique au-dessus du SDK généré : authentification
 * (login -> JWT), **rafraîchissement automatique du token**, **signature
 * HMAC anti-rejeu** (si un `hmacSecret` est fourni) et APIs typées par
 * domaine pré-configurées.
 *
 * ```php
 * $nita = NitaClient::connect([
 *     'environment' => 'sandbox',
 *     'apiKey' => $apiKey,
 *     'login' => $login,
 *     'password' => $password,
 *     'hmacSecret' => $secret,
 * ]);
 * $solde = NitaClient::unwrap($nita->compte()->consulterSoldeCompte());
 * ```
 *
 * @package Nita\Sdk
 */
class NitaClient
{
    /**
     * URLs par environnement. Aucune n'est encore publique : `connect()` lève
     * tant que `baseUrl` n'est pas fourni explicitement.
     */
    public const ENVIRONMENTS = [
        'sandbox' => null, // TODO: URL publique du sandbox
        'production' => null, // TODO: URL de production
    ];

    /** Délai d'expiration par défaut (secondes) d'un appel HTTP complet. */
    public const DEFAULT_TIMEOUT_SECONDS = 30;

    /** Délai d'expiration par défaut (secondes) de l'établissement de la connexion. */
    public const DEFAULT_CONNECT_TIMEOUT_SECONDS = 10;

    /** Marge (secondes) avant expiration à partir de laquelle on rafraîchit proactivement le JWT. */
    private const REFRESH_SKEW_SECONDS = 30;

    /** @var string */
    private $baseUrl;

    /** @var string */
    private $apiKey;

    /** @var string|null */
    private $hmacSecret;

    /** @var string */
    private $token;

    /** @var string|null */
    private $refreshToken;

    /** @var Client Client Guzzle avec le middleware de signature HMAC branché. */
    private $guzzle;

    /** @var Configuration */
    private $config;

    /** @var array{timeout: float, connect_timeout: float} Options Guzzle de délai d'expiration. */
    private $timeouts;

    private function __construct(
        string $baseUrl,
        string $apiKey,
        ?string $hmacSecret,
        string $token,
        ?string $refreshToken,
        array $timeouts
    ) {
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;
        $this->hmacSecret = $hmacSecret;
        $this->token = $token;
        $this->refreshToken = $refreshToken;
        $this->timeouts = $timeouts;

        $this->guzzle = self::makeSigningClient($hmacSecret, $timeouts);

        $this->config = new Configuration();
        $this->config->setHost($this->baseUrl);
        $this->config->setApiKey('X-NT-API-KEY', $apiKey); // lu via Configuration::getApiKeyWithPrefix('X-NT-API-KEY')
        $this->config->setAccessToken($token);              // préfixe "Bearer " ajouté par le SDK généré
    }

    /**
     * Se connecte (login -> JWT via `/api/authenticate`) et renvoie une
     * instance prête à l'emploi.
     *
     * @param array{
     *     baseUrl?: string,
     *     environment?: string,
     *     apiKey: string,
     *     login: string,
     *     password: string,
     *     hmacSecret?: string,
     *     timeoutSeconds?: int|float,
     *     connectTimeoutSeconds?: int|float
     * } $opts Options : `baseUrl` (explicite, prioritaire) ou `environment`
     *          (preset `sandbox`/`production`, def. `sandbox`), `apiKey`
     *          (clé partenaire X-NT-API-KEY), `login`/`password`
     *          (identifiants `/api/authenticate`), `hmacSecret` (secret de
     *          signature anti-rejeu, optionnel -- obligatoire en production),
     *          `timeoutSeconds` (délai max d'un appel, def. 30) et
     *          `connectTimeoutSeconds` (délai max de connexion, def. 10),
     *          appliqués à tous les appels HTTP du client.
     * @return self
     */
    public static function connect(array $opts): self
    {
        $environment = $opts['environment'] ?? 'sandbox';
        $baseUrl = $opts['baseUrl'] ?? (self::ENVIRONMENTS[$environment] ?? null);
        if (!$baseUrl) {
            throw new \InvalidArgumentException(
                "URL de base introuvable pour l'environnement '{$environment}'. " .
                "Passe 'baseUrl' explicitement (l'URL est indiquée dans ton espace partenaire)."
            );
        }

        $apiKey = $opts['apiKey'] ?? null;
        $login = $opts['login'] ?? null;
        $password = $opts['password'] ?? null;
        if (!$apiKey || !$login || !$password) {
            throw new \InvalidArgumentException("NitaClient::connect requiert 'apiKey', 'login' et 'password'.");
        }
        $hmacSecret = $opts['hmacSecret'] ?? null;
        $timeouts = self::timeouts($opts);

        $session = self::postAuth($baseUrl, '/api/authenticate', $apiKey, $hmacSecret, [
            'username' => $login,
            'password' => $password,
        ], $timeouts);

        return new self($baseUrl, $apiKey, $hmacSecret, $session['token'], $session['refreshToken'], $timeouts);
    }

    /** Force le rafraîchissement du token via `/api/refreshToken`. */
    public function refresh(): void
    {
        if (!$this->refreshToken) {
            throw new \RuntimeException('Aucun refreshToken disponible pour rafraîchir la session.');
        }

        $session = self::postAuth($this->baseUrl, '/api/refreshToken', $this->apiKey, $this->hmacSecret, [
            'refreshToken' => $this->refreshToken,
        ], $this->timeouts);

        $this->token = $session['token'];
        $this->refreshToken = $session['refreshToken'] ?? $this->refreshToken;
        $this->config->setAccessToken($this->token);
    }

    /** Rafraîchit proactivement le token s'il expire dans moins de {@see REFRESH_SKEW_SECONDS}. */
    private function ensureFreshToken(): void
    {
        $exp = Jwt::exp($this->token);
        if ($exp !== null && $this->refreshToken && ($exp - time()) < self::REFRESH_SKEW_SECONDS) {
            $this->refresh();
        }
    }

    public function compte(): CompteV2Api
    {
        $this->ensureFreshToken();

        return new CompteV2Api($this->guzzle, $this->config);
    }

    public function localites(): LocalitsV2Api
    {
        $this->ensureFreshToken();

        return new LocalitsV2Api($this->guzzle, $this->config);
    }

    public function transactions(): TransactionsV2Api
    {
        $this->ensureFreshToken();

        return new TransactionsV2Api($this->guzzle, $this->config);
    }

    public function checkStatus(): CheckingV2Api
    {
        $this->ensureFreshToken();

        return new CheckingV2Api($this->guzzle, $this->config);
    }

    public function myNita(): MyNitaV2Api
    {
        $this->ensureFreshToken();

        return new MyNitaV2Api($this->guzzle, $this->config);
    }

    public function achat(): AchatEnLigneV2Api
    {
        $this->ensureFreshToken();

        return new AchatEnLigneV2Api($this->guzzle, $this->config);
    }

    public function p2p(): EnvoiInterPartenaireV2Api
    {
        $this->ensureFreshToken();

        return new EnvoiInterPartenaireV2Api($this->guzzle, $this->config);
    }

    /**
     * Renvoie le `data` typé d'une enveloppe NITA si `status` est un succès
     * -- comparaison **INSENSIBLE À LA CASSE** (`success`/`Success`/`SUCCESS`
     * selon l'endpoint) -- sinon lève une {@see NitaError}. Évite au
     * partenaire de tester `status`/`code` à chaque appel.
     *
     * @param ModelInterface $response Réponse d'un appel d'Api générée (ApisResponse, ApisResponseV2*...).
     * @return mixed Le contenu de `getData()`.
     * @throws NitaError Si `status` n'est pas un succès.
     */
    public static function unwrap(ModelInterface $response)
    {
        $status = $response->getStatus();
        if (is_string($status) && strtolower($status) === 'success') {
            return $response->getData();
        }

        throw new NitaError($response);
    }

    /**
     * Identifiant de requête unique (`<prefix>-<epoch>-<random>`) -- un
     * `requestId` réutilisé est REJETÉ côté serveur (pas de rejeu idempotent).
     */
    public static function newRequestId(string $prefix = 'req'): string
    {
        return sprintf('%s-%d-%s', $prefix, time(), substr(bin2hex(random_bytes(4)), 0, 6));
    }

    /**
     * Client Guzzle qui signe CHAQUE requête ayant un corps (si `$hmacSecret`
     * fourni) -- voir {@see Hmac::attach()}. C'est ce client (pas un client
     * Guzzle nu) qui est passé aux Api du SDK généré.
     */
    private static function makeSigningClient(?string $hmacSecret, array $timeouts): Client
    {
        $stack = HandlerStack::create();
        if ($hmacSecret) {
            Hmac::attach($stack, $hmacSecret);
        }

        return new Client(['handler' => $stack] + $timeouts);
    }

    /**
     * Options Guzzle de délai d'expiration tirées de `connect()` (Guzzle, par
     * défaut, attend indéfiniment).
     *
     * @param array<string, mixed> $opts
     * @return array{timeout: float, connect_timeout: float}
     */
    private static function timeouts(array $opts): array
    {
        $timeout = $opts['timeoutSeconds'] ?? self::DEFAULT_TIMEOUT_SECONDS;
        $connectTimeout = $opts['connectTimeoutSeconds'] ?? self::DEFAULT_CONNECT_TIMEOUT_SECONDS;
        if (!is_numeric($timeout) || $timeout <= 0 || !is_numeric($connectTimeout) || $connectTimeout <= 0) {
            throw new \InvalidArgumentException("'timeoutSeconds' et 'connectTimeoutSeconds' doivent etre > 0.");
        }

        return ['timeout' => (float) $timeout, 'connect_timeout' => (float) $connectTimeout];
    }

    /**
     * POST `/api/authenticate` ou `/api/refreshToken` -> `{token, refreshToken}`,
     * signé si `$hmacSecret` est fourni. Appel HTTP brut (ces deux endpoints
     * sont hors spec OpenAPI v2) sur un client Guzzle nu -- au moment du
     * login initial, le client signé de l'instance n'existe pas encore.
     *
     * @param array<string, string> $payload
     * @param array{timeout: float, connect_timeout: float} $timeouts
     * @return array{token: string, refreshToken: string|null}
     */
    private static function postAuth(
        string $baseUrl,
        string $path,
        string $apiKey,
        ?string $hmacSecret,
        array $payload,
        array $timeouts
    ): array {
        $body = json_encode($payload, JSON_UNESCAPED_SLASHES);
        $headers = [
            'X-NT-API-KEY' => $apiKey,
            'Content-Type' => 'application/json',
        ];
        if ($hmacSecret) {
            $headers = array_merge($headers, Hmac::signatureHeaders($hmacSecret, $body));
        }

        $client = new Client($timeouts);
        try {
            $response = $client->post(rtrim($baseUrl, '/') . $path, [
                'headers' => $headers,
                'body' => $body,
            ]);
        } catch (GuzzleException $e) {
            $detail = $e->getMessage();
            if (method_exists($e, 'getResponse') && $e->getResponse() !== null) {
                $detail = substr((string) $e->getResponse()->getBody(), 0, 200);
            }
            throw new \RuntimeException("{$path} -> {$detail}", 0, $e);
        }

        $json = json_decode((string) $response->getBody(), true);
        $token = $json['data']['token'] ?? $json['token'] ?? null;
        if (!$token) {
            throw new \RuntimeException(
                "Token absent de la réponse {$path} : " . substr((string) $response->getBody(), 0, 200)
            );
        }
        $refreshToken = $json['data']['refreshToken'] ?? $json['refreshToken'] ?? null;

        return ['token' => $token, 'refreshToken' => $refreshToken];
    }
}
