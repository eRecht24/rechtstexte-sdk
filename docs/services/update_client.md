# Update existing project client
This service updates an existing project client for the given `api_key`.
After updating client, you will receive a new secret.

## Step by step integration
### Preparation
Before getting started, you should ensure that you have already finished the steps described [here](../preparation.md).

### Prepare api data
Now you have to collect all information that should be sent to our api server.
You can either collect data in an associative array:
```php 
$data = [
    'client_id' => 1, // (required)
    'push_method' => 'POST',  // (required) either "POST" or "GET"
    'push_uri' => 'https://www.test.de', // (required) valid url
    'cms' => 'WORDPRESS', // (optional)
    'cms_version' => '5.7.1', // (optional)
    'plugin_name' => 'custom_plugin', // (optional)
    'author_mail' => 'developer@e-recht24.de', // (optional)
];
```
or you can simply use our client model:
```php
$data = new \ERecht24\Model\Client([
    'client_id' => 1, // (required)
    'push_method' => 'POST',  // (required) either "POST" or "GET"
    'push_uri' => 'https://www.test.de', // (required) valid url
    'cms' => 'WORDPRESS', // (optional)
    'cms_version' => '5.7.1', // (optional)
    'plugin_name' => 'custom_plugin', // (optional)
    'author_mail' => 'developer@e-recht24.de', // (optional)
]);
```
Both ways will work the same way. 
However, we recommend using our model, since it validates that only valid data will be handed over to the api client.
**Note: You always have to specify a valid `client_id`. All Other attributes are optional. Only given data will be updated. Data other than that will stay untouched. Even using our model.**

### Execute service
With the help of our `$apiClient` and `$data` we are now able to initialize and execute our service.

```php
/** @var \ERecht24\ApiClient $apiClient */
/** @var \ERecht24\Model\Client|array $data */
$service = new \ERecht24\Service\ClientUpdateService($apiClient, $data);
$service->execute();
```

### Handle response
Learn how to handle responses in general [here](../handle_api_responses.md).

**Note: After you updated a client, you have to store the new secret in your database. It will be used to check if pushes are authorized.**

```php
$secret = $service->getResponse()->getBodyDataByKey('secret');
```


## Full Script
```php
// require composer autoloader
require_once '<path_to_project_root>/vendor/autoload.php'; // update to your needs

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'; // update to your needs
$apiClient = new \ERecht24\ApiClient($apiKey);

// collect data
$data = new \ERecht24\Model\Client([
    'client_id' => 1, // (required)
    'push_method' => 'POST',  // (required) either "POST" or "GET"
    'push_uri' => 'https://www.test.de', // (required) valid url
    'cms' => 'WORDPRESS', // (optional)
    'cms_version' => '5.7.1', // (optional)
    'plugin_name' => 'custom_plugin', // (optional)
    'author_mail' => 'developer@e-recht24.de', // (optional)
]);

// execute service
$service = new \ERecht24\Service\ClientUpdateService($apiClient, $data);
$service->execute();

// get secret
$secret = $service->getResponse()->getBodyDataByKey('secret');
```