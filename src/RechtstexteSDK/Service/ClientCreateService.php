<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Service;

use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Exception;
use eRecht24\RechtstexteSDK\Interfaces\ServiceInterface;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Service as BaseService;

class ClientCreateService extends BaseService implements ServiceInterface
{
    /**
     * @var string
     */
    protected $apiEndpoint = '/v1/clients';

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
            throw new Exception('Argument 2 passed to eRecht24\RechtstexteSDK\Service\ClientCreateService::__construct() must be an instance of eRecht24\RechtstexteSDK\Model\Client or array.', 500);
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
            ->setPath($this->getApiEndpoint())
            ->setMethod(ApiClient::HTTP_POST)
            ->setPostFields($this->client->getAttributes())
            ->makeRequest();

        return $this;
    }
}