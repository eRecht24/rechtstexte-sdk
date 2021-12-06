# Preparation
Before you can use one of our services, you have to follow these steps.
Otherwise, services can not be executed correctly.

## Step by step integration
### Step 1
Please make sure that you installed this package as described in [README.md](../README.md) and your application makes use of composer autoloader. 
The most modern frameworks already include all necessary files. If not, simply modify and add this line to your script.

```php
require_once '<path_to_project_root>/vendor/autoload.php'; // update to your needs
```

### Step 2
Now initialize our api client with your `api_key`.
You can get your `api_key` here: [eRecht24 Projekt-Manager](https://www.e-recht24.de/mitglieder/tools/projekt-manager/)

```php
$apiKey = 'ENTER-YOUR-API-KEY-HERE'; // update to your needs
$apiClient = new \ERecht24\ApiClient($apiKey);
```


## Full script
```php
// require composer autoloader
require_once '<path_to_project_root>/vendor/autoload.php'; // update to your needs

// Initalize api client
$apiKey = 'ENTER-YOUR-API-KEY-HERE'; // update to your needs
$client = new \ERecht24\ApiClien($apiKey);

// add services here

```