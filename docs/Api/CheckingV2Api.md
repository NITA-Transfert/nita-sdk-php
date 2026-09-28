# Nita\Sdk\CheckingV2Api

All URIs are relative to http://localhost:8584, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**checkRequestOperation()**](CheckingV2Api.md#checkRequestOperation) | **POST** /api/v2/nitaServices/checkStatus/transaction | Vérification de l&#39;état d&#39;un envoi |


## `checkRequestOperation()`

```php
checkRequestOperation($checkTransactionRequest): \Nita\Sdk\Model\ApisResponseV2CheckStatusResponseV2
```

Vérification de l'état d'un envoi

Vérifie si un envoi s'est bien passé via le requestId fourni en JSON body.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\CheckingV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$checkTransactionRequest = new \Nita\Sdk\Model\CheckTransactionRequest(); // \Nita\Sdk\Model\CheckTransactionRequest

try {
    $result = $apiInstance->checkRequestOperation($checkTransactionRequest);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CheckingV2Api->checkRequestOperation: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **checkTransactionRequest** | [**\Nita\Sdk\Model\CheckTransactionRequest**](../Model/CheckTransactionRequest.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2CheckStatusResponseV2**](../Model/ApisResponseV2CheckStatusResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
