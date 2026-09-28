<?php

/**
 * Jwt
 *
 * Couche mince écrite à la main (NON générée par openapi-generator) --
 * protégée de la régénération via .openapi-generator-ignore.
 *
 * @package Nita\Sdk
 */

namespace Nita\Sdk;

/**
 * Lecture du champ `exp` (expiration, en secondes epoch) d'un JWT, SANS
 * validation de la signature -- utilisé uniquement pour décider si le token
 * doit être rafraîchi proactivement (voir {@see NitaClient}).
 *
 * @package Nita\Sdk
 */
final class Jwt
{
    private function __construct()
    {
        // Classe utilitaire statique -- non instanciable.
    }

    /**
     * Renvoie l'expiration (epoch secondes) d'un JWT, ou null si absente ou
     * illisible (payload non JSON, moins de 2 segments...).
     *
     * @param string $token Le JWT (segments séparés par des points, header.payload.signature).
     * @return int|null
     */
    public static function exp(string $token): ?int
    {
        $parts = explode('.', $token);
        if (count($parts) < 2) {
            return null;
        }

        $json = self::base64UrlDecode($parts[1]);
        if ($json === null) {
            return null;
        }

        $payload = json_decode($json, true);
        if (!is_array($payload) || !isset($payload['exp']) || !is_numeric($payload['exp'])) {
            return null;
        }

        return (int) $payload['exp'];
    }

    /**
     * Décode un segment base64url en texte. Renvoie null si le décodage échoue.
     */
    private static function base64UrlDecode(string $segment): ?string
    {
        $base64 = strtr($segment, '-_', '+/');
        $padded = str_pad($base64, strlen($base64) + ((4 - strlen($base64) % 4) % 4), '=');
        $decoded = base64_decode($padded, true);

        return $decoded === false ? null : $decoded;
    }
}
