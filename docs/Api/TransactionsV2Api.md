# Nita\Sdk\TransactionsV2Api

All URIs are relative to http://localhost:8584, except if the operation defines another base path.

| Method | HTTP request | Description |
| ------------- | ------------- | ------------- |
| [**annulePartenaireToWallet()**](TransactionsV2Api.md#annulePartenaireToWallet) | **POST** /api/v2/nitaServices/transaction/AnnulePartenaireToWallet | Annulation Partenaire To Wallet (v2) |
| [**annulerEnvoiMyNita()**](TransactionsV2Api.md#annulerEnvoiMyNita) | **PUT** /api/v2/nitaServices/transaction/annulerEnvoi | Annuler un envoi MyNita (v2) |
| [**calculerFraisPartenaireToCash()**](TransactionsV2Api.md#calculerFraisPartenaireToCash) | **POST** /api/v2/nitaServices/transaction/partenaireToCash/frais | Calcul des frais Partenaire To Cash (P2C) |
| [**calculerFraisPartenaireToWallet()**](TransactionsV2Api.md#calculerFraisPartenaireToWallet) | **POST** /api/v2/nitaServices/transaction/partenaireToWallet/frais | Calcul des frais Partenaire To Wallet (P2W) |
| [**getEnvoiToEdit()**](TransactionsV2Api.md#getEnvoiToEdit) | **POST** /api/v2/nitaServices/transaction/getEnvoiToEdit | Récupérer les informations d&#39;un envoi à éditer (v2) |
| [**getPartenaireToWallet()**](TransactionsV2Api.md#getPartenaireToWallet) | **POST** /api/v2/nitaServices/transaction/GetPartenaireToWallet | Récupération d&#39;une opération Partenaire To Wallet (v2) |
| [**partenaireToCash()**](TransactionsV2Api.md#partenaireToCash) | **POST** /api/v2/nitaServices/transaction/partenaireToCash | Envoi Partenaire To Cash (v2) |
| [**partenaireToWallet()**](TransactionsV2Api.md#partenaireToWallet) | **POST** /api/v2/nitaServices/transaction/partenaireToWallet | Partenaire To Wallet (v2) |
| [**updateEnvoiMyNita()**](TransactionsV2Api.md#updateEnvoiMyNita) | **PUT** /api/v2/nitaServices/transaction/updateEnvoi | Modifier un envoi MyNita (v2) |


## `annulePartenaireToWallet()`

```php
annulePartenaireToWallet($annulePartenaireToWalletModel): \Nita\Sdk\Model\ApisResponseV2AnnulationPartenaireToWalletResponseV2
```

Annulation Partenaire To Wallet (v2)

Annule une transaction Partenaire TO Wallet.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$annulePartenaireToWalletModel = new \Nita\Sdk\Model\AnnulePartenaireToWalletModel(); // \Nita\Sdk\Model\AnnulePartenaireToWalletModel

try {
    $result = $apiInstance->annulePartenaireToWallet($annulePartenaireToWalletModel);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->annulePartenaireToWallet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **annulePartenaireToWalletModel** | [**\Nita\Sdk\Model\AnnulePartenaireToWalletModel**](../Model/AnnulePartenaireToWalletModel.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2AnnulationPartenaireToWalletResponseV2**](../Model/ApisResponseV2AnnulationPartenaireToWalletResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `annulerEnvoiMyNita()`

```php
annulerEnvoiMyNita($annulationDto): \Nita\Sdk\Model\ApisResponseV2TransactionResponseV2
```

Annuler un envoi MyNita (v2)

Annule l'envoi correspondant au CodeEnvoi fourni.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$annulationDto = new \Nita\Sdk\Model\AnnulationDto(); // \Nita\Sdk\Model\AnnulationDto

try {
    $result = $apiInstance->annulerEnvoiMyNita($annulationDto);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->annulerEnvoiMyNita: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **annulationDto** | [**\Nita\Sdk\Model\AnnulationDto**](../Model/AnnulationDto.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2TransactionResponseV2**](../Model/ApisResponseV2TransactionResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `calculerFraisPartenaireToCash()`

```php
calculerFraisPartenaireToCash($calculeFraisOperationRequest): \Nita\Sdk\Model\ApisResponseV2FraisPreviewResponseV2
```

Calcul des frais Partenaire To Cash (P2C)

Calcule les frais d'un envoi cash selon la grille tarifaire (profil CCP par defaut, ou BIN) et la destination, sans debit. L'organisation destinataire est portee par la ville de destination.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$calculeFraisOperationRequest = new \Nita\Sdk\Model\CalculeFraisOperationRequest(); // \Nita\Sdk\Model\CalculeFraisOperationRequest

try {
    $result = $apiInstance->calculerFraisPartenaireToCash($calculeFraisOperationRequest);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->calculerFraisPartenaireToCash: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **calculeFraisOperationRequest** | [**\Nita\Sdk\Model\CalculeFraisOperationRequest**](../Model/CalculeFraisOperationRequest.md)|  | |

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

## `calculerFraisPartenaireToWallet()`

```php
calculerFraisPartenaireToWallet($partenaireToWalletFraisRequest): \Nita\Sdk\Model\ApisResponseV2FraisPreviewResponseV2
```

Calcul des frais Partenaire To Wallet (P2W)

Calcule les frais d'une recharge P2W sans debit. Le montant retourne est celui qui sera reellement debite : meme profil, meme organisation destinataire (pays du wallet client) et meme reduction eventuelle.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$partenaireToWalletFraisRequest = new \Nita\Sdk\Model\PartenaireToWalletFraisRequest(); // \Nita\Sdk\Model\PartenaireToWalletFraisRequest

try {
    $result = $apiInstance->calculerFraisPartenaireToWallet($partenaireToWalletFraisRequest);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->calculerFraisPartenaireToWallet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **partenaireToWalletFraisRequest** | [**\Nita\Sdk\Model\PartenaireToWalletFraisRequest**](../Model/PartenaireToWalletFraisRequest.md)|  | |

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

## `getEnvoiToEdit()`

```php
getEnvoiToEdit($envoiToEditDto): \Nita\Sdk\Model\ApisResponseV2ModelEditEnvoieRequest
```

Récupérer les informations d'un envoi à éditer (v2)

Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$envoiToEditDto = new \Nita\Sdk\Model\EnvoiToEditDto(); // \Nita\Sdk\Model\EnvoiToEditDto

try {
    $result = $apiInstance->getEnvoiToEdit($envoiToEditDto);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->getEnvoiToEdit: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **envoiToEditDto** | [**\Nita\Sdk\Model\EnvoiToEditDto**](../Model/EnvoiToEditDto.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2ModelEditEnvoieRequest**](../Model/ApisResponseV2ModelEditEnvoieRequest.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `getPartenaireToWallet()`

```php
getPartenaireToWallet($getPartenaireToWalletModel): \Nita\Sdk\Model\ApisResponseV2GetPartenaireToWalletResponseV2
```

Récupération d'une opération Partenaire To Wallet (v2)

Récupère les détails d'une opération P2W à partir du requestId et du codeRecharge.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$getPartenaireToWalletModel = new \Nita\Sdk\Model\GetPartenaireToWalletModel(); // \Nita\Sdk\Model\GetPartenaireToWalletModel

try {
    $result = $apiInstance->getPartenaireToWallet($getPartenaireToWalletModel);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->getPartenaireToWallet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **getPartenaireToWalletModel** | [**\Nita\Sdk\Model\GetPartenaireToWalletModel**](../Model/GetPartenaireToWalletModel.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2GetPartenaireToWalletResponseV2**](../Model/ApisResponseV2GetPartenaireToWalletResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `partenaireToCash()`

```php
partenaireToCash($partenaireToCashDtoV2): \Nita\Sdk\Model\ApisResponseV2TransactionResponseV2
```

Envoi Partenaire To Cash (v2)

Effectue un envoi Partenaire To Cash. Photos de pièce d'identité transmises en Base64 dans le JSON body.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$partenaireToCashDtoV2 = new \Nita\Sdk\Model\PartenaireToCashDtoV2(); // \Nita\Sdk\Model\PartenaireToCashDtoV2

try {
    $result = $apiInstance->partenaireToCash($partenaireToCashDtoV2);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->partenaireToCash: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **partenaireToCashDtoV2** | [**\Nita\Sdk\Model\PartenaireToCashDtoV2**](../Model/PartenaireToCashDtoV2.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2TransactionResponseV2**](../Model/ApisResponseV2TransactionResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `partenaireToWallet()`

```php
partenaireToWallet($partenaireToWalletModel): \Nita\Sdk\Model\ApisResponseV2PartenaireToWalletResponseV2
```

Partenaire To Wallet (v2)

Effectue une transaction Partenaire TO Wallet.    Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$partenaireToWalletModel = new \Nita\Sdk\Model\PartenaireToWalletModel(); // \Nita\Sdk\Model\PartenaireToWalletModel

try {
    $result = $apiInstance->partenaireToWallet($partenaireToWalletModel);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->partenaireToWallet: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **partenaireToWalletModel** | [**\Nita\Sdk\Model\PartenaireToWalletModel**](../Model/PartenaireToWalletModel.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2PartenaireToWalletResponseV2**](../Model/ApisResponseV2PartenaireToWalletResponseV2.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `updateEnvoiMyNita()`

```php
updateEnvoiMyNita($updateEnvoiDto): \Nita\Sdk\Model\ApisResponseV2Void
```

Modifier un envoi MyNita (v2)

Requiert la signature HMAC : en-tetes X-NT-TIMESTAMP, X-NT-NONCE et X-NT-SIGNATURE (voir la description de l'API). Les SDK officiels les posent automatiquement.

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


$apiInstance = new Nita\Sdk\Api\TransactionsV2Api(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$updateEnvoiDto = new \Nita\Sdk\Model\UpdateEnvoiDto(); // \Nita\Sdk\Model\UpdateEnvoiDto

try {
    $result = $apiInstance->updateEnvoiMyNita($updateEnvoiDto);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling TransactionsV2Api->updateEnvoiMyNita: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

| Name | Type | Description  | Notes |
| ------------- | ------------- | ------------- | ------------- |
| **updateEnvoiDto** | [**\Nita\Sdk\Model\UpdateEnvoiDto**](../Model/UpdateEnvoiDto.md)|  | |

### Return type

[**\Nita\Sdk\Model\ApisResponseV2Void**](../Model/ApisResponseV2Void.md)

### Authorization

[ApiKey](../../README.md#ApiKey), [bearerAuth](../../README.md#bearerAuth)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
