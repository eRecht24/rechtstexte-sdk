# Delete existing Project Client
This service deletes an existing project client for the given `api_key`.

## Step by step integration
### Preparation
Before getting started, you should ensure that you have already finished the steps described [here](../preparation.md).

### Execute service
With the help of our `$apiClient` we are now able to initialize and execute our service.
```php
$client_id = 123;
/** @var \ERecht24\ApiClient $apiClient */
$service = new \ERecht24\Service\ClientDeleteService($apiClient, $client_id);
$service->execute();
```

### Handle response
Learn how to handle responses in general [here](../handle_api_responses.md).
Our api does not return data. 
However, checking response success might be a good idea. 
```php
$success = $service->getResponse()->isSuccess();
```

## Full Script

```php
// require composer autoloader
require_once '<path_to_project_root>/vendor/autoload.php'; // update to your needs

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'; // update to your needs
$apiClient = new \ERecht24\ApiClient($apiKey);

// execute service
$client_id = 123; // update to your needs
$service = new \ERecht24\Service\ClientDeleteService($apiClient, $client_id);
$service->execute();

// get secret
$success = $service->getResponse()->isSuccess();
```