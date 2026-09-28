# Nita\Sdk\MyNitaV2Api

All URIs are relative to http://localhost:8584, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**checkCompteExistence()**](MyNitaV2Api.md#checkCompteExistence) | **POST** /api/v2/nitaServices/compteMynita/checkCompteExistence | Vérifier l&#39;existence d&#39;un compte MyNita |


## `checkCompteExistence()`

```php
checkCompteExistence($verificationCompteDtoV2): \Nita\Sdk\Model\ApisResponseV2String
```

Vérifier l'existence d'un compte MyNita

Vérifie si un compte MyNita existe pour un numéro de téléphone donné.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\MyNitaV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$verificationCompteDtoV2 = new \Nita\Sdk\Model\VerificationCompteDtoV2(); // \Nita\Sdk\Model\VerificationCompteDtoV2

try {
    $result = $apiInstance->checkCompteExistence($verificationCompteDtoV2);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling MyNitaV2Api->checkCompteExistence: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **verificationCompteDtoV2** | [**\Nita\Sdk\Model\VerificationCompteDtoV2**](../Model/VerificationCompteDtoV2.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2String**](../Model/ApisResponseV2String.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
