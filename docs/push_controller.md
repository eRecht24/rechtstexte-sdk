# Push controller example
When the eRecht24 server pushes a notification to your client you have to ensure this request is authorized.
This example shows in a very simple overview all steps needed to be done.
The `Helper` methods will help you handle the `type` validation and ping processing.
```php
use eRecht24\RechtstexteSDK\Helper\Helper;
use eRecht24\RechtstexteSDK\LegalTextHandler;
use \eRecht24\RechtstexteSDK\Model\LegalText;

class PushController
{
    public function handleRequest($request)
    {
        $params = $request->getParams();

        // validate Secret
        $secret = $params[Helper::ERECHT24_PUSH_PARAM_SECRET] ?? '';
        if (!validateSecret($secret)) {
            sendResponse(401, 'Unauthorized request.');
            return;
        }

        // validate type
        $type = $params[Helper::ERECHT24_PUSH_PARAM_TYPE] ?? '';
        if (!Helper::isValidPushType($type)) {
            sendResponse(422, 'Invalid type requested.');
            return;
        }

        switch ($type) {
            case Helper::PUSH_TYPE_PING:
                sendResponse(200, Helper::getPingResponse());
                return;
            case Helper::PUSH_TYPE_IMPRINT:
            case Helper::PUSH_TYPE_PRIVACY_POLICY:
            case Helper::PUSH_TYPE_PRIVACY_POLICY_SOCIAL_MEDIA:
                $legalTextHandler = new LegalTextHandler('YOUR_API_KEY', $type);
                /* @var LegalText $legalText */
                $legalText = $legalTextHandler->importDocument();

                { ... }
                $legalText->getHtmlDE();
                { ... }

                return;
        }
    }
}
```
