# Get privacy policy for social media data
This service provides privacy policy for social media data for the given `api_key`.

## Step by step integration
### Preparation
Before getting started, you should ensure that you have already finished the steps described [here](../preparation.md).

### Execute service
With the help of our `$apiClient` we are now able to initialize and execute our service.
```php
/** @var \ERecht24\ApiClient $apiClient */
$service = new \ERecht24\Service\PrivacyPolicySocialMediaGetService($apiClient);
$service->execute();
```

### Handle response
Learn how to handle responses in general [here](../handle_api_responses.md).
If you do not want to work with raw response data, you can use the function `getLegalText()` to retrieve a [legal text](../../src/Model/LegalText.php).
It will be filled with all information provided by our api. 

```php
/** @var \ERecht24\Model\LegalText|null $privacy_policy_social_media */
$privacy_policy_social_media = $service->execute()->getLegalText();
$english_html = $privacy_policy_social_media->html_en;
$german_html = $privacy_policy_social_media->html_de;
```
**Note: If Request was not successfull, $privacy_policy_social_media will be `null`. In this case you may use raw response to get more information**
```php
if (is_null($privacy_policy_social_media)) {
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
$apiClient = new \ERecht24\ApiClient($apiKey);

// execute service
$service = new \ERecht24\Service\PrivacyPolicySocialMediaGetService($apiClient);
$service->execute();

// get privacy policy
/** @var \ERecht24\Model\LegalText|null $privacy_policy_social_media */
$privacy_policy_social_media = $service->execute()->getLegalText();
```