<?php
declare(strict_types=1);

namespace ERecht24\Service;

use ERecht24\ApiClient;
use ERecht24\Collection;
use ERecht24\Exception;
use ERecht24\Interfaces\ServiceInterface;
use ERecht24\Model\Client;
use ERecht24\Model\Response;
use ERecht24\Service as BaseService;

class ClientDeleteService extends BaseService implements ServiceInterface
{
    protected $apiEndpoint = '/v1/clients/%s';
    /**
     * @var int
     */
    private $clientId;

    /**
     * ClientDeleteService constructor.
     * @param ApiClient $apiClient
     * @param int $clientId
     */
    public function __construct(
        ApiClient $apiClient,
        int $clientId
    ) {
        parent::__construct($apiClient);
        $this->clientId = $clientId;
    }

    /**
     * Execute service
     * @return ServiceInterface
     * @throws Exception
     */
    public function execute(): ServiceInterface
    {
        $this->response = $this->apiClient
            ->setPath(sprintf($this->getApiEndpoint(), $this->clientId))
            ->setMethod(ApiClient::HTTP_DELETE)
            ->makeRequest()
        ;

        return $this;
    }
}