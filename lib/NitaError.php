<?php

/**
 * NitaError
 *
 * Couche mince écrite à la main (NON générée par openapi-generator) --
 * protégée de la régénération via .openapi-generator-ignore.
 *
 * @package Nita\Sdk
 */

namespace Nita\Sdk;

use Nita\Sdk\Model\ModelInterface;

/**
 * Erreur métier NITA. Levée par {@see NitaClient::unwrap()} quand l'enveloppe
 * de réponse a un `status` autre que succès -- souvent renvoyée en **HTTP
 * 200** avec le détail dans l'enveloppe (ApisResponse / ApisResponseV2*),
 * donc le SDK généré ne lève rien de lui-même : c'est `unwrap` qui transforme
 * ce cas en exception typée.
 *
 * @package Nita\Sdk
 */
class NitaError extends \Exception
{
    /** @var string Statut canonique renvoyé (ERROR, ALERT, NOT_FOUND, CONFLICT...). */
    protected $status;

    /** @var mixed Charge utile éventuelle accompagnant l'erreur. */
    protected $data;

    /**
     * @param ModelInterface $response Enveloppe de réponse générée (expose getStatus/getCode/getMessage/getData,
     *                                 comme toutes les ApisResponse[...] du SDK généré).
     */
    public function __construct(ModelInterface $response)
    {
        $status = $response->getStatus();
        $code = $response->getCode();
        $message = $response->getMessage();

        parent::__construct(
            $message !== null && $message !== '' ? $message : 'NITA a répondu ' . ($status ?: 'ERROR'),
            (int) ($code ?? 0)
        );

        $this->status = $status ?: 'ERROR';
        $this->data = $response->getData();
    }

    /** Statut canonique renvoyé (ERROR, ALERT, NOT_FOUND, CONFLICT...). */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Charge utile éventuelle accompagnant l'erreur.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
