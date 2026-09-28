# Nita\Sdk\EnvoiInterPartenaireV2Api

All URIs are relative to http://localhost:8584, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**calculerFraisEnvoiInterPartenaire()**](EnvoiInterPartenaireV2Api.md#calculerFraisEnvoiInterPartenaire) | **POST** /api/v2/nitaServices/envoi-inter-partenaire/frais | Calcul des frais d&#39;un envoi inter-partenaire (P2P) |
| [**creerEnvoiInterPartenaire()**](EnvoiInterPartenaireV2Api.md#creerEnvoiInterPartenaire) | **POST** /api/v2/nitaServices/envoi-inter-partenaire/creation | Créer un envoi inter-partenaire (P2P) |


## `calculerFraisEnvoiInterPartenaire()`

```php
calculerFraisEnvoiInterPartenaire($envoiInterPartenaireFraisRequest): \Nita\Sdk\Model\ApisResponseV2FraisPreviewResponseV2
```

Calcul des frais d'un envoi inter-partenaire (P2P)

Calcule les frais d'un envoi entre le partenaire authentifie et un partenaire destinataire (identifie par alias), sans debit. Meme resolution inter-organisation et meme bareme que le debit reel.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKey
$config = Nita\Sdk\Configuration::getDefaultConfiguration()->setApiKey('X-NT-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Nita\Sdk\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-NT-API-KEY', 'Bearer');

// Configure Bearer (JWT) authorization: bearerAuth
$config = Nita\Sdk\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Nita\Sdk\Api\EnvoiInterPartenaireV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$envoiInterPartenaireFraisRequest = new \Nita\Sdk\Model\EnvoiInterPartenaireFraisRequest(); // \Nita\Sdk\Model\EnvoiInterPartenaireFraisRequest

try {
    $result = $apiInstance->calculerFraisEnvoiInterPartenaire($envoiInterPartenaireFraisRequest);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiInterPartenaireV2Api->calculerFraisEnvoiInterPartenaire: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **envoiInterPartenaireFraisRequest** | [**\Nita\Sdk\Model\EnvoiInterPartenaireFraisRequest**](../Model/EnvoiInterPartenaireFraisRequest.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2FraisPreviewResponseV2**](../Model/ApisResponseV2FraisPreviewResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `creerEnvoiInterPartenaire()`

```php
creerEnvoiInterPartenaire($envoiInterPartenaireRequest): \Nita\Sdk\Model\ApisResponseV2EnvoiInterPartenaireResponseV2
```

Créer un envoi inter-partenaire (P2P)

Crée un envoi de fonds entre le partenaire authentifié et un partenaire destinataire (identifié par alias) de la même organisation. Idempotent via requestId.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure API key authorization: ApiKey
$config = Nita\Sdk\Configuration::getDefaultConfiguration()->setApiKey('X-NT-API-KEY', 'YOUR_API_KEY');
// Uncomment below to setup prefix (e.g. Bearer) for API key, if needed
// $config = Nita\Sdk\Configuration::getDefaultConfiguration()->setApiKeyPrefix('X-NT-API-KEY', 'Bearer');

// Configure Bearer (JWT) authorization: bearerAuth
$config = Nita\Sdk\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');


$apiInstance = new Nita\Sdk\Api\EnvoiInterPartenaireV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$envoiInterPartenaireRequest = new \Nita\Sdk\Model\EnvoiInterPartenaireRequest(); // \Nita\Sdk\Model\EnvoiInterPartenaireRequest

try {
    $result = $apiInstance->creerEnvoiInterPartenaire($envoiInterPartenaireRequest);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling EnvoiInterPartenaireV2Api->creerEnvoiInterPartenaire: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **envoiInterPartenaireRequest** | [**\Nita\Sdk\Model\EnvoiInterPartenaireRequest**](../Model/EnvoiInterPartenaireRequest.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2EnvoiInterPartenaireResponseV2**](../Model/ApisResponseV2EnvoiInterPartenaireResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
