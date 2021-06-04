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

class ImprintGetService extends BaseService implements ServiceInterface
{
    protected $apiEndpoint = '/v1/imprint';

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
     * @return LegalText
     */
    public function getLegalText() : ?LegalText
    {
        if (200 != $this->getResponse()->code)
            return null;

        if (is_null($this->result)) {
            $legalText = new LegalText(
                $this->getResponse()->body_data
            );
            $this->result = $legalText->setType(LegalText::TYPE_IMPRINT);
        }

        return $this->result;
    }
}