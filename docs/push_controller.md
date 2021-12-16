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
        $secret = $params[Helper::ERECHT24_PUSH_PARAM_SECRET] ?? '';
        if (!validateSecret($secret)) {
            return sendResponse('Unauthorized request.', 401);
        }

        // validate type
        $type = $params[Helper::ERECHT24_PUSH_PARAM_TYPE] ?? '';
        if (!Helper::isValidPushType($type)) {
            return sendResponse('Invalid type requested.', 422);
        }

        switch ($type) {
            case Helper::PUSH_TYPE_PING:
                return sendResponse(Helper::getPingResponse(), 200);
            case Helper::PUSH_TYPE_IMPRINT:
            case Helper::PUSH_TYPE_PRIVACY_POLICY:
            case Helper::PUSH_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA:
                return handleWhateverIsTodo($type);
        }
    }
}
```
