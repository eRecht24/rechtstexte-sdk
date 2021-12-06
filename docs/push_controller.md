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
     * This function should be called if when push_uri is requested 
     */
    public function handleRequest()
    {
        // validate secrets 
        $requestSecret = $_POST['erecht24_secret'] ?? $_GET['erecht24_secret'];
        $databaseSecret = $this->getDatabaseSecret();
        if (is_null($databaseSecret) || $databaseSecret != $requestSecret)
            return $this->sendResponse('Unauthorized request. Wrong Secret.', 'Unautorisierte Anfrage. Falsches Secret', 401);
    
        // ensure that erecht24_type is correct
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
        // add your logik here
    }

    /**
     * Update legal_text in database
     * @param LegalText $legal_text
     */
    private function importLegalText(
	    LegalText $legal_text
    ) : void
    {
        $html_de = $legal_text->html_de;
        $html_en = $legal_text->html_en;
        // add your logik here
    }

    /**
     * Send response
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
        
        // add further logik here.
        // Make sure that request status_code = $code and request body = json from $body
    }

    /**
     * @param string $type
     * @throws \eRecht24\RechtstexteSDK\Exception
     */
    private function handleLegalDocument( 
        string $type
    ) {
        // Initalize api client
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
    
        // validate that request was successful
        if (!$service->getResponse()->isSuccess)
            return $this->sendResponse('Failed request. Error while importing the document.', 'Fehlgeschlagene Anfrage. Fehler beim Importieren des Dokuments', 400);
    
        // validate that model is not null
        $legal_text = $service->getLegalText();
        if (!$legal_text)
            return $this->sendResponse('Failed request. Error while importing the document.', 'Fehlgeschlagene Anfrage. Fehler beim Importieren des Dokuments', 400);
    
        // import legal text
        $this->importLegalText($legal_text);

        // send success response    
        return $this->sendResponse('Document successfully imported', 'Dokument erfolgreich importiert', 200);
    }
}
```
