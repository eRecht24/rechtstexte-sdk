# Legal text model
Legal texts can be created using the [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/).
With the **eRecht24 Rechtstexte-SDK** you are able to import those texts in a simple way.

## Properties
```php
/**
 * @class eRecht24\RechtstexteSDK\Model\LegalText
 *
 * @property int client_id          // client_id is used to identify user`s client 
 * @property int project_id         // project_id is used to identify user`s project
 * @property string html_de         // German version of legal text 
 * @property string html_en         // English version of legal text
 * @property string warnings        // warnings
 * @property string pushed          // last client pushed date
 * @property string created         // client creation date
 * @property string modified        // last client updated date
 */
```

### Receiving attribute values
You can receive a property like this:
```php
/** @var \eRecht24\RechtstexteSDK\Model\LegalText $model */
$html_de = $model->html_de;
```
or like this:
```php
/** @var \eRecht24\RechtstexteSDK\Model\LegalText $model */
$html_en = $model->getAttribute('html_en');
```

### Setting attribute values
You can set a property like this:
```php
/** @var \eRecht24\RechtstexteSDK\Model\LegalText $model */
$model->setAttribute('html_en', '<body>...</body>');
```
or like this:
```php
/** @var \eRecht24\RechtstexteSDK\Model\LegalText $model */
$model->fill([
    'html_en' => '<body>...</body>',
    'client_id' => 123
]);
```


## Types
```php
// available types
const TYPE_IMPRINT = 'imprint';
const TYPE_PRIVACY_POLICY = 'privacy_policy';
const TYPE_PRIVACY_POLICY_SOCIAL_MEDIA = 'privacy_policy_social_media';

// getting a type
/** @var \eRecht24\RechtstexteSDK\Model\LegalText $model */
$type = $model->getType();

// setting a type
$model->setType($model::TYPE_IMPRINT);
 ```

