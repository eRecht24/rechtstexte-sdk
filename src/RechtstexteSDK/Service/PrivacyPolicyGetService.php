<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Service;

use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Exception;
use eRecht24\RechtstexteSDK\Interfaces\ServiceInterface;
use eRecht24\RechtstexteSDK\Model;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\LegalText;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service as BaseService;

class PrivacyPolicyGetService extends BaseService implements ServiceInterface
{
    /**
     * @var string
     */
    protected $apiEndpoint = '/v1/privacyPolicy';

    /**
     * @var LegalText|null
     */
    protected $result;

    /**
     * Execute service
     *
     * @return ServiceInterface
     * @throws Exception
     */
    public function execute(): ServiceInterface
    {
        $this->response = $this->apiClient
            ->setPath($this->getApiEndpoint())
            ->setMethod(ApiClient::HTTP_GET)
            ->makeRequest();

        return $this;
    }

    /**
     * Get Legal Text model filled with response data
     *
     * @return LegalText
     */
    public function getLegalText(): ?LegalText
    {
        if (!$this->getResponse()->isSuccess())
            return null;

        if (is_null($this->result)) {
            $legalText = new LegalText(
                $this->getResponse()->body_data
            );
            $this->result = $legalText->setType(LegalText::TYPE_PRIVACY_POLICY);
        }

        return $this->result;
    }

    /**
     * Provide Service Result
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->getLegalText();
    }
}