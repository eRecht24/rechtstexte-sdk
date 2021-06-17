# Client - Model
A client needs to be registerer in order to receive push notifications. Without registration, you won't be able to push legal documents to the client.
Every registered client receives a client_id and a secret. Please store both values on the client side.
The secret is used to check whether incoming push notifications are from eRecht24 and to prevent DoS attacks against our servers.
The client_id can be used to update stored client information or to delete the client.


## Properties
```php
/**
 * @class ERecht24\Model\Client
 *
 * @property int client_id          // client_id is used to identify user`s client 
 * @property int project_id         // project_id is used to identify user`s project
 * @property string push_method     // HTTP method of push_uri "GET" or "POST"
 * @property string push_uri        // HTTP url endpoint
 * @property string cms             // name of cms (not mandatory, but they will help us in case of failures)
 * @property string cms_version     // version of cms (not mandatory, but they will help us in case of failures)
 * @property string plugin_name     // plugin name (not mandatory, but they will help us in case of failures)
 * @property string author_mail     // plugin author email (not mandatory, but they will help us in case of failures)
 * @property string created_at      // client creation date
 * @property string updated_at      // client update date
 */
```

### Editable properties
You can only modify those properties when creating or updating a client via api. Other properties will be ignored.
```php
/**
 * @property string push_method     // HTTP method of push_uri "GET" or "POST"
 * @property string push_uri        // HTTP url endpoint
 * @property string cms             // name of cms (not mandatory, but they will help us in case of failures)
 * @property string cms_version     // version of cms (not mandatory, but they will help us in case of failures)
 * @property string plugin_name     // plugin name (not mandatory, but they will help us in case of failures)
 * @property string author_mail     // plugin author email (not mandatory, but they will help us in case of failures)
 */
```

### Receiving attribute values
You can receive a property like this:
```php
/** @var \ERecht24\Model\Client $model */
$cms = $model->cms;
```
or like this:
```php
/** @var \ERecht24\Model\Client $model */
$cms_version = $model->getAttribute('cms_version');
```

### Setting attribute values
You can set a property like this:
```php
/** @var \ERecht24\Model\Client $model */
$model->setAttribute('cms_version', '1.0.9');
```
or like this:
```php
/** @var \ERecht24\Model\Client $model */
$model->fill([
    'plugin_name' => 'custom_plugin',
    'push_method' => 'POST'
]);
```
