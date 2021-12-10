# eRecht24 Rechtstexte-SDK
The eRecht24 Rechtstexte-SDK allows your service/server to interact with the eRecht24.de API.
This package is under official supported by eRecht24.de.
We would recommend using this package in order to use the eRecht24.de services.

## Requirements
[PHP 7.1 or better](https://www.php.net/)

## Installation
Add the package using composer:

```shell
composer require erecht24/rechtstexte-sdk:"<2.0"
```

##############################################################################
(if available at any packagist/satis there will be text here)
##############################################################################

## Quickstart
### Create your API key
Keys may be generated using the [eRecht24 Projekt Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/).
There is a key for development and testing purpose. Feel free to use it:

```e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117```

### The legal text model
The [base model](./docs/legal_text.md) for three different legal text types.

- [Imprint](./docs/legal_text.md#imprint)
- [Privacy policy](./docs/legal_text.md#privacy-policy)
- [Privacy policy social media](./docs/legal_text.md#privacy-policy-social-media)

After getting a document object you can read the html text:
```php
if ($imprint = $apiHandler->getImprint()) {
    $html = $imprint->getHtmlDE();
}
```
or with dynmamic language support:
```php
if ($imprint = $apiHandler->getImprint()) {
    $html = $imprint->getHtml('en');
}
```

### The client model
Registered [clients](./docs/client.md) may receive push notifications.
```php
// new client data
$newClient = (new Client())
    ->setPushMethod('POST')
    ->setPushUri('https://test.de/push')
    ->setCms('WP')
    ->setCmsVersion('8.0')
    ->setPluginName('erecht24/rechtstexte-wp')
    ->setAuthorMail('test@test.de');
```
There is a limit of 3 clients per project.

### Usage :: code example
This simple example register a new client with your project (api-key) and get an actual html version of the imprint text. 

```php
// require composer autoloader, update/extend to your needs
// require_once '<path_to_project_root>/vendor/autoload.php';

use eRecht24\RechtstexteSDK\ApiHandler;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Exceptions\Exception;

// initialize api handler
$apiHandler = new ApiHandler('ENTER-YOUR-API-KEY-HERE');

// the new client data
$newClient = (new Client())
    ->setPushMethod('POST')
    ->setPushUri('https://test.de/push')
    ->setCms('WP')
    ->setCmsVersion('8.0')
    ->setPluginName('erecht24/rechtstexte-wp')
    ->setAuthorMail('test@test.de');

try {
    // create the new client
    $client = $apiHandler->createClient($newClient);

    if (!$apiHandler->isLastResponseSuccess()) {
        // do stuff in case of an error
    }

    if ($imprint = $apiHandler->getImprint()) {
        // example: get DE imprint
        $html = $imprint->getHtmlDE();
    }

} catch (Exception $e) {
    // as you need, log or rethrow here
}

// now go on with whatever service you want to execute
```
See full documentation of the [API handler](./docs/api_handler.md) for other service actions.

## Licence
Please check out our [Terms of use](LICENSE).

## Services
The eRecht24.de API documentation can be found [here](https://docs.api.e-recht24.de/).










