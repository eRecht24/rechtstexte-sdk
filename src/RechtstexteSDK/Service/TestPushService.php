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

class TestPushService extends BaseService implements ServiceInterface
{
    /**
     * @var string
     */
    protected $apiEndpoint = '/v1/clients/%s/testPush';

    /**
     * @var int
     */
    private $clientId;

    /**
     * @param ApiClient $apiClient
     * @param int $clientId
     */
    public function __construct(
        ApiClient $apiClient,
        int       $clientId
    )
    {
        parent::__construct($apiClient);
        $this->clientId = $clientId;
    }

    /**
     * Execute service
     *
     * @return ServiceInterface
     * @throws Exception
     */
    public function execute(): ServiceInterface
    {
        $this->response = $this->apiClient
            ->setPath(sprintf($this->getApiEndpoint(), $this->clientId))
            ->setMethod(ApiClient::HTTP_POST)
            ->makeRequest();

        return $this;
    }
}