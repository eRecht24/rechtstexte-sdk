<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Service;

use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Exception;
use eRecht24\RechtstexteSDK\Interfaces\ServiceInterface;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service as BaseService;

class ClientUpdateService extends BaseService implements ServiceInterface
{
    /**
     * @var string
     */
    protected $apiEndpoint = '/v1/clients/%s';

    /**
     * @var Client
     */
    private $client;

    /**
     * ClientCreateService constructor.
     *
     * @param ApiClient $apiClient
     * @param Client|array $client
     * @throws Exception
     */
    public function __construct(
        ApiClient $apiClient,
                  $client
    )
    {
        parent::__construct($apiClient);
        if ($client instanceof Client)
            $this->client = $client;
        elseif (is_array($client))
            $this->client = new Client($client);
        else
            throw new Exception('Argument 2 passed to eRecht24\RechtstexteSDK\Service\ClientUpdateService::__construct() must be an instance of eRecht24\RechtstexteSDK\Model\Client or array.', 500);
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
            ->setPath(sprintf($this->getApiEndpoint(), $this->client->client_id))
            ->setMethod(ApiClient::HTTP_PUT)
            ->setPostFields($this->client->getAttributes())
            ->makeRequest();

        return $this;
    }
}