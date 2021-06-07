<?php
declare(strict_types=1);

namespace ERecht24\Service;

use ERecht24\ApiClient;
use ERecht24\Collection;
use ERecht24\Exception;
use ERecht24\Interfaces\ServiceInterface;
use ERecht24\Model\Client;
use ERecht24\Service as BaseService;

class ClientListService extends BaseService implements ServiceInterface
{
    protected $apiEndpoint = '/v1/clients';

    /**
     * @var Collection|null
     */
    protected $result;

    /**
     * Execute service
     * @return ServiceInterface
     * @throws Exception
     */
    public function execute(): ServiceInterface
    {
        $this->response = $this->apiClient
            ->setPath($this->getApiEndpoint())
            ->setMethod(ApiClient::HTTP_GET)
            ->makeRequest()
        ;

        return $this;
    }

    /**
     * Get collection model filled with response data
     * @return ?Collection
     */
    public function getCollection() : ?Collection
    {
        if ($this->getResponse()->isSuccess())
            return null;

        if (is_null($this->result)) {
            $this->result = new Collection();

            foreach ($this->getResponse()->body_data as $clientData) {
                $this->result->add(new Client($clientData));
            }
        }

        return $this->result;
    }
}