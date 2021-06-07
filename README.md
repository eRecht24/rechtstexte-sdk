# eRecht24 Rechtstexte Api Package

The eRecht24 API Client Library enables you to work with eRecht24 APIs such as Legal texts on your server.
These client libraries are officially supported by eRecht24.
However, the libraries are considered complete and are in maintenance mode. This means that we will address critical bugs and security issues but will not add any new features.

We encourage you to implement this Package in order to use the eRecht24.de services in your custom application.

## Licence 
Apache 2.0

## Requirements
[PHP 7.1 or higher](https://www.php.net/)

## Installation
You can use Composer or simply Download the Release

### Composer

The preferred method is via composer. Follow the installation instructions if you do not already have composer installed.
Once composer is installed, execute the following command in your project root to install this library:

```shell
  composer require eRecht24/apiclient:"<2.0"
```

Finally, be sure to include the autoloader:

```php
  require_once '/path/to/your-project/vendor/autoload.php';
```

### Download the Release
If you prefer not to use composer, you can download the package in its entirety.
The Releases page lists all stable versions.
Download any file with the name google-api-php-client-[RELEASE_NAME].zip for a package including this library.

## How to use it
### Basics
#### Get an API key
Keys can be created in the future using the [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/). All API keys are sha256 hashes. You can save them as varchar(64).
For development you can use the API key **e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117**.

#### Legal Text - Model
Legal Texts can be created using the [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/).
With the help of the **eRecht24 Rechtstexte Api Package** you are able to import those texts.
```php
/**
 * @class ERecht24\Model\LegalText
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

#### Project Client - Model
A client needs to register in order to receive push notifications. Without registration, you won't be able to push legal documents to the client.
Every registered client receives a client_id and a secret. Please store both values on the client side.
The secret is used to check whether incoming push notifications are from eRecht24 and to prevent DoS attacks against our servers.
The client_id can be used to update stored client information or to delete the client.
```php
/**
 * @class ERecht24\Model\Client
 *
 * @property int client_id          // client_id is used to identify user`s client 
 * @property int project_id         // project_id is used to identify user`s project
 * @property string push_method     // HTTP method of push_uri "GET" or "POST"
 * @property string push_uri        // HTTP url endpoint
 * @property string cms             // name of cms (optional for development)
 * @property string cms_version     // version of cms (optional for development)
 * @property string plugin_name     // plugin name (optional for development)
 * @property string author_mail     // plugin author email (optional for development)
 * @property string created_at      // client creation date
 * @property string updated_at      // client update date
 */
```

#### Response - Model
We introduced a Model for Api responses to help you to work with our api client.
However, we want to minimize dependencies in order to keep the package slim.
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

// checks if request was successful
public function isSuccess() : bool
```

### Services
The full documentation can be found here: [https://docs.api.e-recht24.de/](https://docs.api.e-recht24.de/)

#### List all Project Clients
```php 
use ERecht24\ApiClient;
use ERecht24\Service\ClientListService;

// require composer autoloader
require_once 'vendor/autoload.php';

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// Receive collection of project clients
$service = new ClientListService($client);
$result = $service->execute()->getCollection();

```
`$result = null` if api request is not successful

#### create Project Client
```php 
use ERecht24\ApiClient;
use ERecht24\Model\Client;
use ERecht24\Model\Response;
use ERecht24\Service\ClientCreateService;

// require composer autoloader
require_once 'vendor/autoload.php';

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// create client Model
$clientModel = new Client([
    'push_method' => 'POST',
    'push_uri' => 'https://www.test.de',
    'cms' => 'WORDPRESS',
    'cms_version' => '5.7.1',
    'plugin_name' => 'custom_plugin',
    'author_mail' => 'test@email.com',
]);

// create project client
$service = new ClientCreateService($client, $clientModel);
/** @var Response $result */
$result = $service->execute()->getResponse();
```
use `$result->isSuccess()` to check if request was successful

#### update Project Client
```php 
use ERecht24\ApiClient;
use ERecht24\Model\Client;
use ERecht24\Model\Response;
use ERecht24\Service\ClientUpdateService;

// require composer autoloader
require_once 'vendor/autoload.php';

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// old project client Model
$clientModel = new Client([
    'client_id' => 1,  // your client_id 
    'project_id' => 1, // your project_id
    'push_method' => 'POST',
    'push_uri' => 'https://www.test.de',
    'cms' => 'WORDPRESS',
    'cms_version' => '5.7.1',
    'plugin_name' => 'custom_plugin',
    'author_mail' => 'test@email.com',
]);
// new data
$updates = [
    'push_uri' => 'https://www.test.de/newEndPoint',
    'cms' => 'JOOMLA',
    'cms_version' => '6.4',
    'plugin_name' => 'joomla_plugin',
]
$clientModel->fill($updates)

// update project client
$service = new ClientUpdateService($client, $clientModel);
/** @var Response $result */
$result = $service->execute()->getResponse();
```
use `$result->isSuccess()` to check if request was successful

#### delete Project Client
```php 
use ERecht24\ApiClient;
use ERecht24\Model\Response;
use ERecht24\Service\ClientDeleteService;

// require composer autoloader
require_once 'vendor/autoload.php';

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// delete project client
$id = 1;
$service = new ClientDeleteService($client, $id);
/** @var Response $result */
$result = $service->execute()->getResponse();
```
use `$result->isSuccess()` to check if request was successful

#### get imprint
```php 
use ERecht24\ApiClient;
use ERecht24\Model\Response;
use ERecht24\Service\ImprintGetService;

// require composer autoloader
require_once 'vendor/autoload.php';

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// get imprint
$service = new ImprintGetService($client);
$result = $service->execute()->getLegalText();
```
`$result = null` if api request is not successful

#### get privacy policy
```php 
use ERecht24\ApiClient;
use ERecht24\Model\Response;
use ERecht24\Service\PrivacyPolicyGetService;

// require composer autoloader
require_once 'vendor/autoload.php';

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// get privacy policy
$service = new PrivacyPolicyGetService($client);
$result = $service->execute()->getLegalText();
```
`$result = null` if api request is not successful

#### get privacy policy social media
```php 
use ERecht24\ApiClient;
use ERecht24\Model\Response;
use ERecht24\Service\PrivacyPolicySocialMediaGetService;

// require composer autoloader
require_once 'vendor/autoload.php';

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// get privacy policy social media
$service = new PrivacyPolicySocialMediaGetService($client);
$result = $service->execute()->getLegalText();
```
`$result = null` if api request is not successful

#### get messages
```php 
use ERecht24\ApiClient;
use ERecht24\Model\Response;
use ERecht24\Service\MessageGetService;

// require composer autoloader
require_once 'vendor/autoload.php';

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// get messages
$service = new MessageGetService($client);
$result = $service->execute()->getResult();
```
use `$result->isSuccess()` to check if request was successful