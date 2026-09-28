# Nita\Sdk\CompteV2Api

All URIs are relative to http://localhost:8584, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**consulterSoldeCompte()**](CompteV2Api.md#consulterSoldeCompte) | **GET** /api/v2/nitaServices/account/balance | Consulter le solde du compte |


## `consulterSoldeCompte()`

```php
consulterSoldeCompte(): \Nita\Sdk\Model\ApisResponseV2Double
```

Consulter le solde du compte

Permet de récupérer le solde du compte de stock.

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


$apiInstance = new Nita\Sdk\Api\CompteV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->consulterSoldeCompte();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling CompteV2Api->consulterSoldeCompte: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\Nita\Sdk\Model\ApisResponseV2Double**](../Model/ApisResponseV2Double.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
