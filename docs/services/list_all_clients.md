# List all Project Clients
This service provides a collection of all project clients that a currently registered for the given `api_key`. 

## Step by Step Integration
### Preparation
Before you can use this service, follow the steps described [here](../preparation.md).

### Execute service
With the help of our `$apiClient` we are now able to initialize and execute our service.
The service prepares the api client, makes the request to our api server and provides all important information.

```php
$service = new \ERecht24\Service\ClientListService($client);
$service->execute();
```

### Handle response
Learn how to handle responses in general [here](../handle_api_responses.md).

### Extra: get collection from service
If you do not want to work with raw response data, you can use the function `getCollection()` to retrieve a collection of all clients.
```php
/** @var \ERecht24\Collection|null $collection */
$collection = $service->getCollection();
```
**Note: If Request was not successfull, $collection will be `null`. In this case you should use raw response to get more information**
```php
if (is_null($collection)) {
    /** @var \ERecht24\Model\Response $response */
    $response = $service->getResponse();
}
```

## Full Script

```php
// require composer autoloader
require_once '<path_to_project_root>/vendor/autoload.php'; // update to your needs

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'; // update to your needs
$client = new \ERecht24\ApiClient($apiKey);

// execute service
$service = new \ERecht24\Service\ClientListService($client);
$service->execute();

// get collection of project clients
/** @var \ERecht24\Collection|null $collection */
$collection = $service->getCollection();
// 
```