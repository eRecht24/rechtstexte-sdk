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

class MessageGetService extends BaseService implements ServiceInterface
{
    /**
     * @var string
     */
    protected $apiEndpoint = '/v1/message';

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
}