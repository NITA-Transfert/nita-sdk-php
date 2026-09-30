# OpenAPIClient-php

APIs partenaires NITA.

Perimetre : endpoints v2 (/api/v2/_**).

Deux couches d'erreurs, a ne pas confondre :

- TRANSPORT (vrais statuts HTTP) : 400 (corps invalide, en-tetes de
  signature absents/malformes), 401 (cle, jeton Bearer ou signature
  invalides, horodatage perime), 403 (produit non souscrit, jeton
  invalide/expire).
- METIER : renvoyee en HTTP 200, le vrai code se trouve dans l'enveloppe
  {status, code, message, data} - par exemple 402, 404, 405, 409
  (requestId deja utilise), 500. Testez le champ `code` du corps, pas le
  seul statut HTTP.

Signature (POST/PUT) : hex(HMAC-SHA256(secret_partenaire, timestamp + \"
\" + nonce + \"
\" + corps)),
portee par X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE. Les SDK officiels
la calculent et la posent au niveau transport.



## Installation & Usage

### Requirements

PHP 7.4 and later.
Should also work with PHP 8.0.

### Composer

Installation via [Composer](https://getcomposer.org/) :

```
composer require nita-transfert/sdk
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/OpenAPIClient-php/vendor/autoload.php');
```

## Getting Started

Please follow the [installation procedure](#installation--usage) and then run the following:

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');



// Configure API key authorization: ApiKey
$config = Nita\Sdk\Configuration::getDefaultConfiguration()->setApiKey('X-NT-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Nita\Sdk\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-NT-API-KEY', 'Bearer');

// Configure Bearer (JWT) authorization: bearerAuth
$config = Nita\Sdk\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Nita\Sdk\Api\AchatEnLigneV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$achatEnLigneModel = new \Nita\Sdk\Model\AchatEnLigneModel(); // \Nita\Sdk\Model\AchatEnLigneModel

try {
    $result = $apiInstance->addAchatEnligne($achatEnLigneModel);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AchatEnLigneV2Api->addAchatEnligne: ', $e->getMessage(), PHP_EOL;
}

```

## Vérifier un callback

Usage serveur uniquement : le SDK exige tous les secrets du partenaire, ne jamais l'embarquer côté client.

NITA signe ses callbacks v2 (POST JSON) avec votre secret HMAC. Vérifiez la signature sur le corps brut, avant tout traitement :

```php
<?php
use Nita\Sdk\CallbackVerifier;
use Nita\Sdk\NitaCallbackException;

// Anti-rejeu : enregistre le nonce dans un stockage partagé (base, Redis...) ; vrai s'il est nouveau.
$isNewNonce = function (string $nonce, int $ttlSeconds) use ($redis): bool {
    return (bool) $redis->set('nita:nonce:' . $nonce, '1', ['nx', 'ex' => $ttlSeconds]);
};
$verifier = new CallbackVerifier(getenv('NITA_HMAC_SECRET'), $isNewNonce);

try {
    $payload = $verifier->verify(file_get_contents('php://input'), getallheaders());
} catch (NitaCallbackException $e) {
    http_response_code(401);
    exit;
}
// $payload['status'], $payload['transaction_id']
```

Sans `$isNewNonce`, un callback valide peut être rejoué pendant la tolérance d'horodatage (300 s par défaut).

Les appels HTTP de `NitaClient` expirent après 30 s (connexion : 10 s) : options `timeoutSeconds` et `connectTimeoutSeconds` de `NitaClient::connect`.

## API Endpoints

All URIs are relative to *http://localhost:8584*

Class | Method | HTTP request | Description
------------ | ------------- | ------------- | -------------
*AchatEnLigneV2Api* | [**addAchatEnligne**](docs/Api/AchatEnLigneV2Api.md#addachatenligne) | **POST** /api/v2/nitaServices/achatEnLigne/saveAchatEnLigne | Créer un achat en ligne
*AchatEnLigneV2Api* | [**annulerAchat**](docs/Api/AchatEnLigneV2Api.md#annulerachat) | **PUT** /api/v2/nitaServices/achatEnLigne/annulerAchat | Annuler un achat
*AchatEnLigneV2Api* | [**checkAchatStatus**](docs/Api/AchatEnLigneV2Api.md#checkachatstatus) | **POST** /api/v2/nitaServices/achatEnLigne/checkAchatStatus | Vérifier le statut d&#39;un achat
*CheckingV2Api* | [**checkRequestOperation**](docs/Api/CheckingV2Api.md#checkrequestoperation) | **POST** /api/v2/nitaServices/checkStatus/transaction | Vérification de l&#39;état d&#39;un envoi
*CompteV2Api* | [**consulterSoldeCompte**](docs/Api/CompteV2Api.md#consultersoldecompte) | **GET** /api/v2/nitaServices/account/balance | Consulter le solde du compte
*EnvoiInterPartenaireV2Api* | [**calculerFraisEnvoiInterPartenaire**](docs/Api/EnvoiInterPartenaireV2Api.md#calculerfraisenvoiinterpartenaire) | **POST** /api/v2/nitaServices/envoi-inter-partenaire/frais | Calcul des frais d&#39;un envoi inter-partenaire (P2P)
*EnvoiInterPartenaireV2Api* | [**creerEnvoiInterPartenaire**](docs/Api/EnvoiInterPartenaireV2Api.md#creerenvoiinterpartenaire) | **POST** /api/v2/nitaServices/envoi-inter-partenaire/creation | Créer un envoi inter-partenaire (P2P)
*LocalitsV2Api* | [**getAllActiveVillesListe**](docs/Api/LocalitsV2Api.md#getallactivevillesliste) | **GET** /api/v2/nitaServices/localite/ville | Obtenir la liste des villes actives
*LocalitsV2Api* | [**getAllIndicatifs**](docs/Api/LocalitsV2Api.md#getallindicatifs) | **GET** /api/v2/nitaServices/localite/pays | Obtenir la liste des indicatifs téléphoniques de tous les pays actifs
*MyNitaV2Api* | [**checkCompteExistence**](docs/Api/MyNitaV2Api.md#checkcompteexistence) | **POST** /api/v2/nitaServices/compteMynita/checkCompteExistence | Vérifier l&#39;existence d&#39;un compte MyNita
*TransactionsV2Api* | [**annulePartenaireToWallet**](docs/Api/TransactionsV2Api.md#annulepartenairetowallet) | **POST** /api/v2/nitaServices/transaction/AnnulePartenaireToWallet | Annulation Partenaire To Wallet (v2)
*TransactionsV2Api* | [**annulerEnvoiMyNita**](docs/Api/TransactionsV2Api.md#annulerenvoimynita) | **PUT** /api/v2/nitaServices/transaction/annulerEnvoi | Annuler un envoi MyNita (v2)
*TransactionsV2Api* | [**calculerFraisPartenaireToCash**](docs/Api/TransactionsV2Api.md#calculerfraispartenairetocash) | **POST** /api/v2/nitaServices/transaction/partenaireToCash/frais | Calcul des frais Partenaire To Cash (P2C)
*TransactionsV2Api* | [**calculerFraisPartenaireToWallet**](docs/Api/TransactionsV2Api.md#calculerfraispartenairetowallet) | **POST** /api/v2/nitaServices/transaction/partenaireToWallet/frais | Calcul des frais Partenaire To Wallet (P2W)
*TransactionsV2Api* | [**getEnvoiToEdit**](docs/Api/TransactionsV2Api.md#getenvoitoedit) | **POST** /api/v2/nitaServices/transaction/getEnvoiToEdit | Récupérer les informations d&#39;un envoi à éditer (v2)
*TransactionsV2Api* | [**getPartenaireToWallet**](docs/Api/TransactionsV2Api.md#getpartenairetowallet) | **POST** /api/v2/nitaServices/transaction/GetPartenaireToWallet | Récupération d&#39;une opération Partenaire To Wallet (v2)
*TransactionsV2Api* | [**partenaireToCash**](docs/Api/TransactionsV2Api.md#partenairetocash) | **POST** /api/v2/nitaServices/transaction/partenaireToCash | Envoi Partenaire To Cash (v2)
*TransactionsV2Api* | [**partenaireToWallet**](docs/Api/TransactionsV2Api.md#partenairetowallet) | **POST** /api/v2/nitaServices/transaction/partenaireToWallet | Partenaire To Wallet (v2)
*TransactionsV2Api* | [**updateEnvoiMyNita**](docs/Api/TransactionsV2Api.md#updateenvoimynita) | **PUT** /api/v2/nitaServices/transaction/updateEnvoi | Modifier un envoi MyNita (v2)

## Models

- [AchatEnLigneModel](docs/Model/AchatEnLigneModel.md)
- [AddAchatEnligneResponseV2](docs/Model/AddAchatEnligneResponseV2.md)
- [AnnulationAchatDto](docs/Model/AnnulationAchatDto.md)
- [AnnulationDto](docs/Model/AnnulationDto.md)
- [AnnulationPartenaireToWalletResponseV2](docs/Model/AnnulationPartenaireToWalletResponseV2.md)
- [AnnulePartenaireToWalletModel](docs/Model/AnnulePartenaireToWalletModel.md)
- [ApisResponseV2](docs/Model/ApisResponseV2.md)
- [ApisResponseV2AddAchatEnligneResponseV2](docs/Model/ApisResponseV2AddAchatEnligneResponseV2.md)
- [ApisResponseV2AnnulationPartenaireToWalletResponseV2](docs/Model/ApisResponseV2AnnulationPartenaireToWalletResponseV2.md)
- [ApisResponseV2CheckAchatStatusResponseV2](docs/Model/ApisResponseV2CheckAchatStatusResponseV2.md)
- [ApisResponseV2CheckStatusResponseV2](docs/Model/ApisResponseV2CheckStatusResponseV2.md)
- [ApisResponseV2Double](docs/Model/ApisResponseV2Double.md)
- [ApisResponseV2EnvoiInterPartenaireResponseV2](docs/Model/ApisResponseV2EnvoiInterPartenaireResponseV2.md)
- [ApisResponseV2FraisPreviewResponseV2](docs/Model/ApisResponseV2FraisPreviewResponseV2.md)
- [ApisResponseV2GetPartenaireToWalletResponseV2](docs/Model/ApisResponseV2GetPartenaireToWalletResponseV2.md)
- [ApisResponseV2IndicatifsResponseV2](docs/Model/ApisResponseV2IndicatifsResponseV2.md)
- [ApisResponseV2ListVilleResponse](docs/Model/ApisResponseV2ListVilleResponse.md)
- [ApisResponseV2ModelEditEnvoieRequest](docs/Model/ApisResponseV2ModelEditEnvoieRequest.md)
- [ApisResponseV2PartenaireToWalletResponseV2](docs/Model/ApisResponseV2PartenaireToWalletResponseV2.md)
- [ApisResponseV2String](docs/Model/ApisResponseV2String.md)
- [ApisResponseV2TransactionResponseV2](docs/Model/ApisResponseV2TransactionResponseV2.md)
- [ApisResponseV2Void](docs/Model/ApisResponseV2Void.md)
- [CalculeFraisOperationRequest](docs/Model/CalculeFraisOperationRequest.md)
- [CheckAchatStatusModel](docs/Model/CheckAchatStatusModel.md)
- [CheckAchatStatusResponseV2](docs/Model/CheckAchatStatusResponseV2.md)
- [CheckStatusResponseV2](docs/Model/CheckStatusResponseV2.md)
- [CheckTransactionRequest](docs/Model/CheckTransactionRequest.md)
- [EnvoiInterPartenaireFraisRequest](docs/Model/EnvoiInterPartenaireFraisRequest.md)
- [EnvoiInterPartenaireRequest](docs/Model/EnvoiInterPartenaireRequest.md)
- [EnvoiInterPartenaireResponseV2](docs/Model/EnvoiInterPartenaireResponseV2.md)
- [EnvoiToEditDto](docs/Model/EnvoiToEditDto.md)
- [FraisPreviewResponseV2](docs/Model/FraisPreviewResponseV2.md)
- [GetPartenaireToWalletModel](docs/Model/GetPartenaireToWalletModel.md)
- [GetPartenaireToWalletResponseV2](docs/Model/GetPartenaireToWalletResponseV2.md)
- [IndicatifResponse](docs/Model/IndicatifResponse.md)
- [IndicatifsResponseV2](docs/Model/IndicatifsResponseV2.md)
- [ModelEditEnvoieRequest](docs/Model/ModelEditEnvoieRequest.md)
- [PartenaireToCashDtoV2](docs/Model/PartenaireToCashDtoV2.md)
- [PartenaireToWalletFraisRequest](docs/Model/PartenaireToWalletFraisRequest.md)
- [PartenaireToWalletModel](docs/Model/PartenaireToWalletModel.md)
- [PartenaireToWalletResponseV2](docs/Model/PartenaireToWalletResponseV2.md)
- [TransactionResponseV2](docs/Model/TransactionResponseV2.md)
- [UpdateEnvoiDto](docs/Model/UpdateEnvoiDto.md)
- [VerificationCompteDtoV2](docs/Model/VerificationCompteDtoV2.md)
- [VilleResponse](docs/Model/VilleResponse.md)

## Authorization

Authentication schemes defined for the API:
### bearerAuth

- **Type**: Bearer authentication (JWT)

### ApiKey

- **Type**: API key
- **API key parameter name**: X-NT-API-KEY
- **Location**: HTTP header


## Tests

To run the tests, use:

```bash
composer install
vendor/bin/phpunit
```

## Author



## About this package

This PHP package is automatically generated by the [OpenAPI Generator](https://openapi-generator.tech) project:

- API version: `1.0`
    - Package version: `2.0.0`
    - Generator version: `7.10.0`
- Build package: `org.openapitools.codegen.languages.PhpClientCodegen`
