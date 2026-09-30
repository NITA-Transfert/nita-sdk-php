<?php

/**
 * CallbackVerifier
 *
 * Couche mince écrite à la main (NON générée par openapi-generator) --
 * protégée de la régénération via .openapi-generator-ignore.
 *
 * @package Nita\Sdk
 */

namespace Nita\Sdk;

/**
 * Vérifie un callback v2 envoyé par NITA au partenaire (POST JSON signé).
 *
 * Même formule que les appels entrants (voir {@see Hmac}) :
 *   hex( HMAC-SHA256(secret, timestamp + "\n" + nonce + "\n" + corpsBrut) )
 * portée par `X-NT-TIMESTAMP`, `X-NT-NONCE` et `X-NT-SIGNATURE`.
 *
 * La signature porte sur les octets BRUTS reçus : passer
 * `file_get_contents('php://input')`, jamais un JSON re-sérialisé.
 *
 * Anti-rejeu : sans `$isNewNonce`, un callback valide peut être rejoué tant
 * que son horodatage reste dans la tolérance. En production, fournir un
 * contrôle adossé à un stockage partagé (base, Redis...) :
 * `function (string $nonce, int $ttlSeconds): bool` qui enregistre le nonce
 * et renvoie `true` s'il n'avait jamais été vu.
 *
 * ```php
 * $verifier = new CallbackVerifier($secret, function (string $nonce, int $ttl) use ($redis) {
 *     return (bool) $redis->set('nita:nonce:' . $nonce, '1', ['nx', 'ex' => $ttl]);
 * });
 * $payload = $verifier->verify(file_get_contents('php://input'), getallheaders());
 * ```
 *
 * @package Nita\Sdk
 */
final class CallbackVerifier
{
    /** Tolérance par défaut (secondes) entre l'horodatage reçu et l'horloge locale. */
    public const DEFAULT_TOLERANCE_SECONDS = 300;

    /** @var string */
    private $secret;

    /** @var callable|null */
    private $isNewNonce;

    /** @var int */
    private $toleranceSeconds;

    /** @var callable|null */
    private $now;

    /**
     * @param string        $secret           Secret de signature du partenaire.
     * @param callable|null $isNewNonce       `(string $nonce, int $ttlSeconds): bool` -- vrai si le nonce est nouveau.
     *                                        Absent : pas d'anti-rejeu.
     * @param int           $toleranceSeconds Écart maximal accepté avec l'horloge locale (défaut 300).
     * @param callable|null $now              `(): int` -- horloge en secondes epoch (défaut `time()`), pour les tests.
     */
    public function __construct(
        string $secret,
        ?callable $isNewNonce = null,
        int $toleranceSeconds = self::DEFAULT_TOLERANCE_SECONDS,
        ?callable $now = null
    ) {
        if ($secret === '') {
            throw new NitaCallbackException('Secret de signature vide');
        }
        $this->secret = $secret;
        $this->isNewNonce = $isNewNonce;
        $this->toleranceSeconds = $toleranceSeconds;
        $this->now = $now;
    }

    /**
     * Vérifie le callback et renvoie son corps décodé (contient `status` et `transaction_id`).
     *
     * @param string               $rawBody Corps brut reçu (octets exacts).
     * @param array<string, mixed> $headers En-têtes reçus, noms insensibles à la casse ;
     *                                      valeur chaîne ou liste (premier élément retenu).
     * @return array<string, mixed>
     * @throws NitaCallbackException Si le callback est refusé.
     */
    public function verify(string $rawBody, array $headers): array
    {
        $timestamp = self::header($headers, 'X-NT-TIMESTAMP');
        $nonce = self::header($headers, 'X-NT-NONCE');
        $signature = self::header($headers, 'X-NT-SIGNATURE');
        if ($timestamp === null || $nonce === null || $signature === null) {
            throw new NitaCallbackException('En-tetes de signature manquants');
        }

        if (!preg_match('/^-?\d+$/', $timestamp)) {
            throw new NitaCallbackException('Horodatage hors tolerance');
        }
        $now = $this->now !== null ? (int) call_user_func($this->now) : time();
        if (abs($now - (int) $timestamp) > $this->toleranceSeconds) {
            throw new NitaCallbackException('Horodatage hors tolerance');
        }

        $expected = hash_hmac('sha256', $timestamp . "\n" . $nonce . "\n" . $rawBody, $this->secret);
        if (!hash_equals($expected, $signature)) {
            throw new NitaCallbackException('Signature invalide');
        }

        if ($this->isNewNonce !== null
            && !call_user_func($this->isNewNonce, $nonce, 2 * $this->toleranceSeconds)) {
            throw new NitaCallbackException('Nonce deja utilise (rejeu)');
        }

        // Décodage objet d'abord : distingue un objet JSON d'un tableau (tous deux `array` en mode assoc).
        if (!(json_decode($rawBody) instanceof \stdClass)) {
            throw new NitaCallbackException('Corps JSON invalide');
        }

        return json_decode($rawBody, true);
    }

    /**
     * Valeur d'un en-tête sans tenir compte de la casse du nom ; `null` si absent ou vide.
     *
     * @param array<string, mixed> $headers
     */
    private static function header(array $headers, string $name): ?string
    {
        foreach ($headers as $key => $value) {
            if (strcasecmp((string) $key, $name) !== 0) {
                continue;
            }
            if (is_array($value)) {
                $value = $value ? reset($value) : null;
            }
            if ($value === null || !is_scalar($value) || (string) $value === '') {
                return null;
            }

            return (string) $value;
        }

        return null;
    }
}
