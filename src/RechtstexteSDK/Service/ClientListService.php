<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Service;

use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Collection;
use eRecht24\RechtstexteSDK\Exception;
use eRecht24\RechtstexteSDK\Interfaces\ServiceInterface;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Service as BaseService;

class ClientListService extends BaseService implements ServiceInterface
{
    /**
     * @var string
     */
    protected $apiEndpoint = '/v1/clients';

    /**
     * @var Collection|null
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
     * Get collection model filled with response data
     *
     * @return ?Collection
     */
    public function getCollection(): ?Collection
    {
        if (!$this->getResponse()->isSuccess())
            return null;

        if (is_null($this->result)) {
            $this->result = new Collection();

            foreach ($this->getResponse()->body_data as $clientData) {
                $this->result->add(new Client($clientData));
            }
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
        return $this->getCollection();
    }
}