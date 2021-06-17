<?php
declare(strict_types=1);

namespace ERecht24\Service;

use ERecht24\ApiClient;
use ERecht24\Exception;
use ERecht24\Interfaces\ServiceInterface;
use ERecht24\Model\Client;
use ERecht24\Service as BaseService;

class ClientUpdateService extends BaseService implements ServiceInterface
{
    protected $apiEndpoint = '/v1/clients/%s';

    /**
     * @var Client
     */
    private $client;

    /**
     * ClientCreateService constructor.
     * @param ApiClient $apiClient
     * @param Client|array $client
     * @throws Exception
     */
    public function __construct(
        ApiClient $apiClient,
        $client
    ) {
        parent::__construct($apiClient);
        if ($client instanceof Client)
            $this->client = $client;
        elseif (is_array($client))
            $this->client = new Client($client);
        else
            throw new Exception('Argument 2 passed to ERecht24\Service\ClientUpdateService::__construct() must be an instance of ERecht24\Model\Client or array.', 500);
    }

    /**
     * Execute service
     * @return ServiceInterface
     * @throws Exception
     */
    public function execute(): ServiceInterface
    {
        $this->response = $this->apiClient
            ->setPath(sprintf($this->getApiEndpoint(), $this->client->client_id))
            ->setMethod(ApiClient::HTTP_PUT)
            ->setPostFields($this->client->getAttributes())
            ->makeRequest()
        ;

        return $this;
    }
}