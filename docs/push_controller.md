# Push controller example
When the eRecht24 server pushes a notification to your client you have to ensure this request is authorized.
This example shows in a very simple overview all steps needed to be done.
The `Helper` methods will help you handle the `type` validation and ping processing.
```php
use eRecht24\RechtstexteSDK\Helper;

class PushController
{
    public function handleRequest($request)
    {
        $params = $request->getParams();

        // validate Secret
        $secret = $params['erecht24_secret'] ?? '';
        if (!validateSecret($secret)) {
            return sendResponse('Unauthorized request.', 401);
        }

        // validate type
        $type = $params['erecht24_type'] ?? '';
        if (!Helper::isValidPushType($type)) {
            return sendResponse('Invalid type requested.', 422);
        }

        switch ($type) {
            case 'ping':
                return sendResponse(Helper::PING_RESPONSE, 200);
            case 'imprint':
            case 'privacyPolicy':
            case 'privacyPolicySocialMedia':
                return handleWhateverIsTodo($type);
        }
    }
}
```
