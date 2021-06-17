# Response - Model
In order to minimize dependencies, we introduced a model for API responses to help you to work with our api client.


## Properties
```php
/**
 * @class ERecht24\Model\Response
 *
 * @property int code           // HTTP status code
 * @property string body        // HTTP body string
 *
 * magic properties
 * @property array body_data    // HTTP body as array
 */
```

### Receiving attribute values
You can receive a property like this:
```php
/** @var \ERecht24\Model\Response $model */
$code = $model->code;
```
or like this:
```php
/** @var \ERecht24\Model\Response $model */
$code = $model->getAttribute('code');
```

### Setting attribute values
You can set a property like this:
```php
/** @var \ERecht24\Model\Response $model */
$model->setAttribute('code', 200);
```
or like this:
```php
/** @var \ERecht24\Model\Response $model */
$model->fill([
    'code' => 200,
    'body' => '{}'
]);
```

## Methods
### isSuccess() : bool
Check if request was successful.
```php
/** @var \ERecht24\Model\Response $model */
$success = $model->isSuccess();
```

### getBodyDataByKey() : mixed
Get certain body data by its key .
```php

$response = new ERecht24\Model\Response([
    'status' => 200,
    'body' => '{"message": "this is a message"}'
]);

$message = $response->getBodyDataByKey('message'); //   = "this is a message"
```