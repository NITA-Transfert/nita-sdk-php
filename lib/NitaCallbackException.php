<?php

/**
 * NitaCallbackException
 *
 * Couche mince écrite à la main (NON générée par openapi-generator) --
 * protégée de la régénération via .openapi-generator-ignore.
 *
 * @package Nita\Sdk
 */

namespace Nita\Sdk;

/**
 * Callback NITA refusé par {@see CallbackVerifier::verify()} : en-têtes
 * manquants, horodatage hors tolérance, signature invalide, nonce rejoué ou
 * corps JSON invalide. Répondre 401/400 à NITA et ne rien traiter.
 *
 * @package Nita\Sdk
 */
class NitaCallbackException extends \RuntimeException
{
}
