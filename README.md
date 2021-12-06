# eRecht24 Rechtstexte API package
The eRecht24 API client library enables you to work with eRecht24 APIs such as legal texts on your server.
These client libraries are officially supported by eRecht24.
We encourage you to implement this package in order to use the eRecht24.de services in your custom application.

## Installation
You can use Composer or simply download the release

### Composer
The preferred method is via composer. Follow their installation instructions if you do not already have composer installed.
Once composer is installed, execute the following command in your project root to install this library:
```shell
  composer require eRecht24/apiclient
```

### Download the release
If you prefer not to use composer, you can download the package in its entirety.
The Releases page lists all stable versions.
Download any file with the name erecht24-apiclient-[RELEASE_NAME].zip for a package including this library.

## How to use it
### 1. Get an API key
API Keys can be created in the future using the [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/). All API keys are sha256 hashes. You can save them as varchar(64).
For development, you can use the API key **e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117**.

### 2. Register Project Clients
A client needs to be registered with a `push_uri` and a `push_method` in order to receive push notifications.
Ensure that the given`push_uri` is publicly accessible with the given `push_method` (GET || POST).
Without registration, you won't be able to push legal documents to the client.
Every registered client receives a client_id and a secret.
Please store both values on the client side.
The `secret` is used to check whether incoming push notifications are from eRecht24.
The client_id can be used to update stored client information or to delete the client.
 
[Reqister client example](docs/services/create_client.md)

### 3. Receiving Pushes
When requested in [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/), our server will send a request to registered `push_uri` via registered `push_method`.
To verify that access to this url is authorized, the `erecht24_secret` from the request must be matched with the `secret` from your database.
You can use the following controller examples as starting point four your custom implementations.
[Push controller example](docs/services/create_client.md)

## Licence
Please check out our [Terms of use](LICENSE).

## Requirements
[PHP 7.1 or higher](https://www.php.net/)