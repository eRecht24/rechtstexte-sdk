<?php
declare(strict_types=1);

namespace ERecht24\Service;

use ERecht24\ApiClient;
use ERecht24\Exception;
use ERecht24\Interfaces\ServiceInterface;
use ERecht24\Model\Client;
use ERecht24\Service as BaseService;

class ClientCreateService extends BaseService implements ServiceInterface
{
    protected $apiEndpoint = '/v1/clients';

    /**
     * @var Client
     */
    private $client;

    /**
     * ClientCreateService constructor.
     * @param ApiClient $apiClient
     * @param Client $client
     */
    public function __construct(
        ApiClient $apiClient,
        Client $client
    ) {
        parent::__construct($apiClient);
        $this->client = $client;
    }

    /**
     * Execute service
     * @return ServiceInterface
     * @throws Exception
     */
    public function execute(): ServiceInterface
    {
        $this->response = $this->apiClient
            ->setPath($this->getApiEndpoint())
            ->setMethod(ApiClient::HTTP_POST)
            ->setPostFields($this->client->getAttributes())
            ->makeRequest()
        ;

        return $this;
    }
}