# eRecht24 Rechtstexte Api Package

The eRecht24 API Client Library enables you to work with eRecht24 APIs such as Legal texts on your server.
These client libraries are officially supported by eRecht24.
However, the libraries are considered complete and are in maintenance mode. This means that we will address critical bugs and security issues but will not add any new features.

We encourage you to implement this Package in order to use the eRecht24.de services in your custom application.

## Licence 
Apache 2.0

## Requirements
[PHP 7.0 or higher](https://www.php.net/)

## Installation
You can use Composer or simply Download the Release

### Composer

The preferred method is via composer. Follow the installation instructions if you do not already have composer installed.
Once composer is installed, execute the following command in your project root to install this library:

```shell
  composer require eRecht24/apiclient:"^2.0"
```

Finally, be sure to include the autoloader:

```php
  require_once '/path/to/your-project/vendor/autoload.php';
```

### Download the Release
If you prefer not to use composer, you can download the package in its entirety.
The Releases page lists all stable versions.
Download any file with the name google-api-php-client-[RELEASE_NAME].zip for a package including this library.