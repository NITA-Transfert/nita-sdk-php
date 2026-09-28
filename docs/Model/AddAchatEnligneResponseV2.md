# # AddAchatEnligneResponseV2

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**publicId** | **string** |  | [optional]
**phoneClient** | **string** |  | [optional]
**requestId** | **string** |  | [optional]
**adresseIP** | **string** |  | [optional]
**codeAchat** | **string** |  | [optional]
**descriptionAchat** | **string** |  | [optional]
**montant** | **float** |  | [optional]
**statusTransaction** | **string** |  | [optional]
**typeTransaction** | **string** |  | [optional]
**comptePartenaire** | **string** |  | [optional]
**nomPartenaire** | **string** |  | [optional]
**prenomPartenaire** | **string** |  | [optional]
**dateTransaction** | **\DateTime** |  | [optional]
**urlPaiement** | **string** | Lien de règlement à transmettre à l&#39;acheteur, dérivé du codeAchat. Nul tant que la page de paiement publique n&#39;est pas en service : un champ absent vaut mieux qu&#39;un lien qui ne s&#39;ouvre pas. Ne pas le reconstruire à la main. | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
