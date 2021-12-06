# Get imprint data
This service provides imprint data for the given `api_key`.

## Step by step integration
### Preparation
Before getting started, you should ensure that you have already finished the steps described [here](../preparation.md).

### Execute service
With the help of our `$apiClient` we are now able to initialize and execute our service.
```php
/** @var \eRecht24\RechtstexteSDK\ApiClient $apiClient */
$service = new \eRecht24\RechtstexteSDK\Service\ImprintGetService($apiClient);
$service->execute();
```

### Handle response
Learn how to handle responses in general [here](../handle_api_responses.md).
If you do not want to work with raw response data, you can use the function `getLegalText()` to retrieve a [legal text](../../src/Model/LegalText.php).
It will be filled with all information provided by our api. 

```php
/** @var \eRecht24\RechtstexteSDK\Model\LegalText|null $imprint */
$imprint = $service->getLegalText();
$english_html = $imprint->html_en;
$german_html = $imprint->html_de;
```
**Note: If Request was not successfull, $imprint will be `null`. In this case you may use raw response to get more information**
```php
if (is_null($imprint)) {
    /** @var \eRecht24\RechtstexteSDK\Model\Response $response */
    $response = $service->getResponse();
}
```

## Full script

```php
// require composer autoloader
require_once '<path_to_project_root>/vendor/autoload.php'; // update to your needs

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'; // update to your needs
$apiClient = new \eRecht24\RechtstexteSDK\ApiClient($apiKey);

// execute service
$service = new \eRecht24\RechtstexteSDK\Service\ImprintGetService($apiClient);
$service->execute();

// get imprint
/** @var \eRecht24\RechtstexteSDK\Model\LegalText|null $imprint */
$imprint = $service->getLegalText();
```