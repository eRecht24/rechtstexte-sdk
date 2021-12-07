# Get messages
This service provides messages for the given `api_key`.

## Step by step integration
### Preparation
Before getting started, you should ensure that you have already finished the steps described [here](../preparation.md).

### Execute service
With the help of our `$apiClient` we are now able to initialize and execute our service.
```php
/** @var \eRecht24\RechtstexteSDK\ApiClient $apiClient */
$service = new \eRecht24\RechtstexteSDK\Service\MessageGetService($apiClient);
$service->execute();
```

### Handle response
Learn how to handle responses in general [here](../handle_api_responses.md).

```php
$german_message = $service->getResponse()->getBodyDataByKey('message_de');
$english_message = $service->getResponse()->getBodyDataByKey('message');
```

## Full script

```php
// require composer autoloader
require_once '<path_to_project_root>/vendor/autoload.php'; // update to your needs

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'; // update to your needs
$apiClient = new \eRecht24\RechtstexteSDK\ApiClient($apiKey);

// execute service
$service = new \eRecht24\RechtstexteSDK\Service\MessageGetService($apiClient);
$service->execute();

// get messages
$german_message = $service->getResponse()->getBodyDataByKey('message_de');
$english_message = $service->getResponse()->getBodyDataByKey('message');
```