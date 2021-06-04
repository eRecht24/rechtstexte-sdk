<?php
declare(strict_types=1);

namespace ERecht24\Service;

use ERecht24\ApiClient;
use ERecht24\Exception;
use ERecht24\Interfaces\ServiceInterface;
use ERecht24\Model;
use ERecht24\Model\Client;
use ERecht24\Model\LegalText;
use ERecht24\Model\Response;
use ERecht24\Service as BaseService;

class MessageGetService extends BaseService implements ServiceInterface
{
    protected $apiEndpoint = '/v1/message';

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
}