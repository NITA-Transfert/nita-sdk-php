# Nita\Sdk\LocalitsV2Api

All URIs are relative to http://localhost:8584, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**getAllActiveVillesListe()**](LocalitsV2Api.md#getAllActiveVillesListe) | **GET** /api/v2/nitaServices/localite/ville | Obtenir la liste des villes actives |
| [**getAllIndicatifs()**](LocalitsV2Api.md#getAllIndicatifs) | **GET** /api/v2/nitaServices/localite/pays | Obtenir la liste des indicatifs téléphoniques de tous les pays actifs |


## `getAllActiveVillesListe()`

```php
getAllActiveVillesListe(): \Nita\Sdk\Model\ApisResponseV2ListVilleResponse
```

Obtenir la liste des villes actives

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


$apiInstance = new Nita\Sdk\Api\LocalitsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->getAllActiveVillesListe();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocalitsV2Api->getAllActiveVillesListe: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\Nita\Sdk\Model\ApisResponseV2ListVilleResponse**](../Model/ApisResponseV2ListVilleResponse.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `*/*`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getAllIndicatifs()`

```php
getAllIndicatifs(): \Nita\Sdk\Model\ApisResponseV2IndicatifsResponseV2
```

Obtenir la liste des indicatifs téléphoniques de tous les pays actifs

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


$apiInstance = new Nita\Sdk\Api\LocalitsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->getAllIndicatifs();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling LocalitsV2Api->getAllIndicatifs: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

This endpoint does not need any parameter.

### Return type

[**\Nita\Sdk\Model\ApisResponseV2IndicatifsResponseV2**](../Model/ApisResponseV2IndicatifsResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `*/*`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
