# Handle api responses
In order to minimize dependencies, our api client provides a minimal API around  [cURL Library](https://www.php.net/manual/en/book.curl.php), allowing you to quickly work with responses from our api server.
For more information check out our [response model](../src/Model/Response.php).

## Retrieve response from a service
After executing one of our services, you have access to the response.
```php
...

/** @var \eRecht24\RechtstexteSDK\Service $service */
$service->execute();  // service was initialized and executed

/** @var \eRecht24\RechtstexteSDK\Model\Response $response */
$response = $service->getResponse();
```

## Check if response was successful
```php
/** @var \eRecht24\RechtstexteSDK\Model\Response $response */
$success = $response->isSuccess(); // bool
```

## Retrieve status code
```php
/** @var \eRecht24\RechtstexteSDK\Model\Response $response */
$status_code = $response->code; // ?int
```

## Retrieve raw body (json)
```php
/** @var \eRecht24\RechtstexteSDK\Model\Response $response */
$body = $response->body; // ?string
```

## Retrieve body as array
```php
/** @var \eRecht24\RechtstexteSDK\Model\Response $response */
$data = $response->body_data; // ?array
```

## Troubleshooting: get error message from failed response
```php
/** @var \eRecht24\RechtstexteSDK\Model\Response $response */
if (!$response->isSuccess()) {
    $german_message = $response->getBodyDataByKey('message_de');
    $english_message = $response->getBodyDataByKey('message');
}
```
