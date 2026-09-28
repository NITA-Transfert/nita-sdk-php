<?php

/**
 * Hmac
 *
 * Couche mince écrite à la main (NON générée par openapi-generator) --
 * protégée de la régénération via .openapi-generator-ignore.
 *
 * @package Nita\Sdk
 */

namespace Nita\Sdk;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;

/**
 * Signature HMAC anti-rejeu -- mécanisme maison NITA, hors spec OpenAPI.
 *
 * Formule (identique prod/sandbox) :
 *   hex( HMAC-SHA256(secret, timestamp + "\n" + nonce + "\n" + corps) )
 * portée par 3 en-têtes : `X-NT-TIMESTAMP` (secondes epoch), `X-NT-NONCE`
 * (hex unique), `X-NT-SIGNATURE`.
 *
 * @package Nita\Sdk
 */
final class Hmac
{
    private function __construct()
    {
        // Classe utilitaire statique -- non instanciable.
    }

    /**
     * Calcule les 3 en-têtes de signature pour un corps donné.
     *
     * @param string $secret Secret de signature partagé.
     * @param string $body   Corps EXACT de la requête (les octets réellement émis).
     * @return array<string, string>
     */
    public static function signatureHeaders(string $secret, string $body): array
    {
        $timestamp = (string) time();
        $nonce = bin2hex(random_bytes(16)); // 32 car. hex -- respecte [A-Za-z0-9-]{8,128}
        $signature = hash_hmac('sha256', $timestamp . "\n" . $nonce . "\n" . $body, $secret);

        return [
            'X-NT-TIMESTAMP' => $timestamp,
            'X-NT-NONCE' => $nonce,
            'X-NT-SIGNATURE' => $signature,
        ];
    }

    /**
     * Signe une requête PSR-7 sortante (relit puis rembobine son corps --
     * ne consomme pas le flux avant l'envoi par le handler HTTP sous-jacent).
     *
     * Signe toute requête non-multipart, Y COMPRIS les GET sans corps : le
     * sandbox exige les 3 en-têtes sur CHAQUE requête (corps vide signé "").
     * Le multipart n'est pas signé (le serveur ne vérifie pas sa signature).
     *
     * @param RequestInterface $request Requête PSR-7 sortante.
     * @param string           $secret  Secret de signature partagé.
     * @return RequestInterface Requête (éventuellement) signée.
     */
    public static function signRequest(RequestInterface $request, string $secret): RequestInterface
    {
        $contentType = $request->getHeaderLine('Content-Type');
        if ($contentType !== '' && stripos($contentType, 'multipart/') === 0) {
            return $request;
        }

        $body = (string) $request->getBody();
        if ($request->getBody()->isSeekable()) {
            $request->getBody()->rewind();
        }

        // Signer AUSSI le corps vide (GET) : les 3 en-têtes sont exigés partout.
        $headers = self::signatureHeaders($secret, $body);
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }

        return $request;
    }

    /**
     * Branche un middleware de signature HMAC sur un HandlerStack Guzzle :
     * signe CHAQUE requête ayant un corps (voir {@see signRequest}). C'est le
     * point d'accroche "intercepteur body-aware" pour PHP/Guzzle (voir
     * smoke/php/smoke.php et smoke/RECIPE.md).
     *
     * @param HandlerStack $stack  Pile de handlers du client Guzzle à instrumenter.
     * @param string       $secret Secret de signature partagé.
     * @return void
     */
    public static function attach(HandlerStack $stack, string $secret): void
    {
        $stack->push(Middleware::mapRequest(static function (RequestInterface $request) use ($secret) {
            return self::signRequest($request, $secret);
        }), 'nita_hmac_signing');
    }
}
