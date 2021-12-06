# eRecht24 Rechtstexte-SDK
The eRecht24 Rechtstexte-SDK allows your service/server to interact with the eRecht24.de API.
This package is under official supported by eRecht24.de, considered to be final and in maintenance mode.
However, this means we will address critical bugs and security issues but will not add any new features.
We would recommend using this package in order to use the eRecht24.de services.

## Installation
You can use ```composer``` or simply download the package.

### Composer
Our preferred method is via composer.

Use the following command to install this package (execute in project root):

```shell
  composer require erecht24/rechtstexte-sdk:"<2.0"
```

and ensure to include the autoloader:

```php
  require_once '/path/to/your-project/vendor/autoload.php';
```

### Download the package
##############################################################################
(if available at any packagist/satis there will be text here)
##############################################################################

## How to use it
### 1. Getting an API key
Keys may be generated using the [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/).
All keys are ```SHA256``` hashes.
You can store them as varchar(64).

There is also a key for development and testing purpose. Feel free to use it:

```e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117```

### 2. Register project clients
Clients have to be registered in order to receive push notifications.
This means, without registration, you won't be able to push legal documents to the client.
Every registered client receives a client_id and a secret. Please store both values on the client side.
The secret is used to check whether incoming push notifications are from eRecht24 and to prevent DoS attacks against our servers.
The client_id can be used to update stored client information or to delete the client.

Please register a client with a `push_uri` and a `push_method`.
If registration is done correctly you'll get a `secret`.
Ensure the given `push_uri` is publicly accessible with the given `push_method` (GET or POST).
Incoming requests to the `push_uri` are authorized, if the `erecht24_secret` parameter in the request matches the `secret` you got while registration process.
 
[Reqister client example](docs/services/create_client.md)

### 3. Receiving pushes
When requested in [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/), our server will send a request to registered `push_uri` via registered `push_method`.
To verify that access to this url is authorized, the `erecht24_secret` from the request must be matched with the `secret` from your database.
You can use the following controller examples as starting point four your custom implementations.
[Push controller example](docs/services/create_client.md)

## Licence
Please check out our [Terms of use](LICENSE).

## Requirements
[PHP 7.1 or better](https://www.php.net/)

## Services
The API documentation can be found [here](https://docs.api.e-recht24.de/).
