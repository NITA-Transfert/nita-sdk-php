# Nita\Sdk\AchatEnLigneV2Api

All URIs are relative to http://localhost:8584, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**addAchatEnligne()**](AchatEnLigneV2Api.md#addAchatEnligne) | **POST** /api/v2/nitaServices/achatEnLigne/saveAchatEnLigne | Créer un achat en ligne |
| [**annulerAchat()**](AchatEnLigneV2Api.md#annulerAchat) | **PUT** /api/v2/nitaServices/achatEnLigne/annulerAchat | Annuler un achat |
| [**checkAchatStatus()**](AchatEnLigneV2Api.md#checkAchatStatus) | **POST** /api/v2/nitaServices/achatEnLigne/checkAchatStatus | Vérifier le statut d&#39;un achat |


## `addAchatEnligne()`

```php
addAchatEnligne($achatEnLigneModel): \Nita\Sdk\Model\ApisResponseV2AddAchatEnligneResponseV2
```

Créer un achat en ligne

Crée un achat en ligne. Toutes les données sont transmises en JSON body.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **achatEnLigneModel** | [**\Nita\Sdk\Model\AchatEnLigneModel**](../Model/AchatEnLigneModel.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2AddAchatEnligneResponseV2**](../Model/ApisResponseV2AddAchatEnligneResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `annulerAchat()`

```php
annulerAchat($annulationAchatDto): \Nita\Sdk\Model\ApisResponseV2CheckAchatStatusResponseV2
```

Annuler un achat

Annule un achat via son codeAchat. L'achat doit être au statut 'non payer'.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\AchatEnLigneV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$annulationAchatDto = new \Nita\Sdk\Model\AnnulationAchatDto(); // \Nita\Sdk\Model\AnnulationAchatDto

try {
    $result = $apiInstance->annulerAchat($annulationAchatDto);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AchatEnLigneV2Api->annulerAchat: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **annulationAchatDto** | [**\Nita\Sdk\Model\AnnulationAchatDto**](../Model/AnnulationAchatDto.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2CheckAchatStatusResponseV2**](../Model/ApisResponseV2CheckAchatStatusResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `checkAchatStatus()`

```php
checkAchatStatus($checkAchatStatusModel): \Nita\Sdk\Model\ApisResponseV2CheckAchatStatusResponseV2
```

Vérifier le statut d'un achat

Vérifie le statut d'un achat en ligne via le requestId.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\AchatEnLigneV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$checkAchatStatusModel = new \Nita\Sdk\Model\CheckAchatStatusModel(); // \Nita\Sdk\Model\CheckAchatStatusModel

try {
    $result = $apiInstance->checkAchatStatus($checkAchatStatusModel);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling AchatEnLigneV2Api->checkAchatStatus: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **checkAchatStatusModel** | [**\Nita\Sdk\Model\CheckAchatStatusModel**](../Model/CheckAchatStatusModel.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2CheckAchatStatusResponseV2**](../Model/ApisResponseV2CheckAchatStatusResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
