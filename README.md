# eRecht24 Rechtstexte-Api-Package
The eRecht24-API-Package allows your service/server to interact with the eRecht24.de API.
This package is under official supported by eRecht24.de, considered to be final and in maintenance mode.
However, this means we will address critical bugs and security issues but will not add any new features.
We would recommend using this package in order to use the eRecht24.de services.

## Licence 
Apache 2.0

## Requirements
[PHP 7.1 or better](https://www.php.net/)

## Installation
You can use ```composer``` or simply download the package.

### Composer
Our preferred method is via composer.

Use the following command in your project root to install this package:

```shell
  composer require eRecht24/apiclient:"<2.0"
```

and ensure to include the autoloader:

```php
  require_once '/path/to/your-project/vendor/autoload.php';
```

### Download the package
##################################################################################################
The Releases page lists all stable versions. <-- wo?

Download any file with the name google-api-php-client-[RELEASE_NAME].zip for a package including this library.
##################################################################################################

## How to use it
### Basics
#### Getting an API Key
Keys may be generated using the [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/).
All keys are ```SHA256``` hashes.
You can store them as varchar(64).

There is also a special key for development. Feel free to use it:

```e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117```

#### Legal Text - Model

Legal texts may be generated using the [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/).

With the help of the **eRecht24-Rechtstexte-Api-Package** you are able to import those texts.

```php
/**
 * @class eRecht24\RechtstexteSDK\Model\LegalText
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
Clients have to be registered in order to receive push notifications.

Without registration, you won't be able to push legal documents to the client.

Every registered client receives a client_id and a secret. Please store both values on the client side.
The secret is used to check whether incoming push notifications are from eRecht24 and to prevent DoS attacks against our servers.
The client_id can be used to update stored client information or to delete the client.

```php
/**
 * @class eRecht24\RechtstexteSDK\Model\Client
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
 * @class eRecht24\RechtstexteSDK\Model\Response
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
use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Service\ClientListService;

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
use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\ClientCreateService;

// require composer autoloader
require_once 'vendor/autoload.php';

// initialize api client
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
use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\ClientUpdateService;

// require composer autoloader
require_once 'vendor/autoload.php';

// initialize api client
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
use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\ClientDeleteService;

// require composer autoloader
require_once 'vendor/autoload.php';

// initialize api client
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
use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\ImprintGetService;

// require composer autoloader
require_once 'vendor/autoload.php';

// initialize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// get imprint
$service = new ImprintGetService($client);
$result = $service->execute()->getLegalText();
```
`$result = null` if api request is not successful

#### get privacy policy
```php 
use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\PrivacyPolicyGetService;

// require composer autoloader
require_once 'vendor/autoload.php';

// initialize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// get privacy policy
$service = new PrivacyPolicyGetService($client);
$result = $service->execute()->getLegalText();
```
`$result = null` if api request is not successful

#### get privacy policy social media
```php 
use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\PrivacyPolicySocialMediaGetService;

// require composer autoloader
require_once 'vendor/autoload.php';

// initialize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// get privacy policy social media
$service = new PrivacyPolicySocialMediaGetService($client);
$result = $service->execute()->getLegalText();
```
`$result = null` if api request is not successful

#### get messages
```php 
use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\MessageGetService;

// require composer autoloader
require_once 'vendor/autoload.php';

// initialize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'
$client = new ApiClient($apiKey);

// get messages
$service = new MessageGetService($client);
$result = $service->execute()->getResult();
```
use `$result->isSuccess()` to check if request was successful

## Receiving Pushes
Please register a client with a `push_uri` and a `push_method`.
If done correctly you receive, you receive a `secret` that has to be saved in you database.
Ensure that the `given push_uri` is publicly accessible with the given `push_method` (GET || POST).
To verify that access to this url is authorized, 
the `erecht24_secret` from the request must be matched with the `secret` from your database.
You can use the following controller examples as starting point four your custom implementations.

### Example Push Controller

```php

use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Model\LegalText;
use eRecht24\RechtstexteSDK\Service\ImprintGetService;
use eRecht24\RechtstexteSDK\Service\PrivacyPolicyGetService;
use eRecht24\RechtstexteSDK\Service\PrivacyPolicySocialMediaGetService;

// require composer autoloader if not done by framework
require_once 'vendor/autoload.php';

class PushController
{
    const ALLOWED_PUSH_TYPES = [
        'ping',
        'imprint',
        'privacyPolicy',
        'privacyPolicySocialMedia',
    ];

    /**
     * This function should be called when push_uri is requested 
     */
    public function handleRequest()
    {
        $requestSecret = $_POST['erecht24_secret'] ?? $_GET['erecht24_secret'];
        $databaseSecret = $this->getDatabaseSecret();
        if (is_null($databaseSecret) || $databaseSecret != $requestSecret)
            return $this->sendResponse('Unauthorized request. Wrong Secret.', 'Unautorisierte Anfrage. Falsches Secret', 401);
    
        $type = $_POST['erecht24_type'] ?? $_GET['erecht24_type'];
        if(!in_array($type, self::ALLOWED_PUSH_TYPES))
            return $this->sendResponse('Failed request. Wrong Type.', 'Fehlgeschlagene Anfrage. Falscher Typ', 400);;
    
        switch ($type){
            case 'ping':
                return $this->sendResponse('pong'); // this is only needed for testPushService
            case 'imprint':
            case 'privacyPolicy':
            case 'privacyPolicySocialMedia':
                return $this->handleLegalDocument($type);
        }
    }

    /**
     * Provide stored client secret from database
     * @return string|null
     */
    private function getDatabaseSecret() : ?string
    {
        // add your logic here
    }

    /**
     * Update legal_text in database
     * @param LegalText $legal_text
     */
    private function importLegalText(
	    LegalText $legal_text
    ) : void
    {
        // add your logic here
    }

    /**
     * @param string $message
     * @param string $message_de
     * @param int $code
     */
    private function sendResponse(
        string $message,
        string $message_de = '',
        int $code = 200
    ) {
        $body = [
            'code'    => $code,
            'message' => $message,
            'message_de' => $message_de
        ];
        
        // add further logic here.
        // Make sure that request status_code = $code and request body = json from $body
    }

    /**
     * @param string $type
     */
    private function handleLegalDocument( 
        string $type
    ) {
        // initialize api client
        $apiKey = 'ENTER-YOUR-API-KEY-HERE';
        $client = new ApiClient($apiKey);
    
        switch ($type) {
            case 'imprint':
                $service = new ImprintGetService($client);
                break;
            case 'privacyPolicy':
                $service = new PrivacyPolicyGetService($client);
                break;
            case 'privacyPolicySocialMedia':
                $service = new PrivacyPolicySocialMediaGetService($client);
                break;
        }
    
        $service->execute();
    
        if (!$service->getResponse()->isSuccess)
            return $this->sendResponse('Failed request. Error while importing the document.', 'Fehlgeschlagene Anfrage. Fehler beim Importieren des Dokuments', 400);
    
        $legal_text = $service->getLegalText();
        if (!$legal_text)
            return $this->sendResponse('Failed request. Error while importing the document.', 'Fehlgeschlagene Anfrage. Fehler beim Importieren des Dokuments', 400);
    
        $this->importLegalText($legal_text);
    
        return $this->sendResponse('Document successfully imported', 'Dokument erfolgreich importiert', 200);
    }
}
```
