<?php

/**
 * Photos
 *
 * Couche mince écrite à la main (NON générée par openapi-generator) --
 * protégée de la régénération via .openapi-generator-ignore.
 *
 * @package Nita\Sdk
 */

namespace Nita\Sdk;

/**
 * Encodage Base64 des pièces d'identité (KYC) pour les endpoints d'envoi
 * (`partenaireToCash`), qui attendent les photos en
 * Base64 dans le corps JSON.
 *
 * Le partenaire fournit des octets bruts (ex. `file_get_contents('cni.jpg')`) --
 * pas de dépendance ni de type spécifique requis.
 *
 * @package Nita\Sdk
 */
final class Photos
{
    private function __construct()
    {
        // Classe utilitaire statique -- non instanciable.
    }

    /** Encode des octets bruts en Base64 (sans préfixe `data:`). */
    public static function toBase64(string $bytes): string
    {
        return base64_encode($bytes);
    }

    /**
     * Encode les pièces d'identité de l'expéditeur en Base64, prêtes à être
     * fusionnées dans un DTO d'envoi :
     *
     *   $photos = Photos::encodePhotos(['recto' => file_get_contents('cni-recto.jpg')]);
     *   $dto = new PartenaireToCashDtoV2(array_merge($champs, $photos));
     *
     * @param array{recto?: string, verso?: string, portrait?: string} $photos Octets bruts, par pièce.
     * @return array{photoPieceIdentiteRecto?: string, photoPieceIdentiteVerso?: string, photoIdentite?: string}
     */
    public static function encodePhotos(array $photos): array
    {
        $fields = [];
        if (isset($photos['recto'])) {
            $fields['photoPieceIdentiteRecto'] = self::toBase64($photos['recto']);
        }
        if (isset($photos['verso'])) {
            $fields['photoPieceIdentiteVerso'] = self::toBase64($photos['verso']);
        }
        if (isset($photos['portrait'])) {
            $fields['photoIdentite'] = self::toBase64($photos['portrait']);
        }

        return $fields;
    }
}
