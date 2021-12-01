<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK;

use eRecht24\RechtstexteSDK\Interfaces\ServiceInterface;
use eRecht24\RechtstexteSDK\Model\Response;

abstract class Service implements ServiceInterface
{
    /**
     * path for url generation
     *
     * @var array
     */
    protected $apiEndpoint = '';

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var ApiClient
     */
    protected $apiClient;

    /**
     * Service constructor.
     *
     * @param ApiClient $apiClient
     */
    public function __construct(
        ApiClient $apiClient
    )
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Provide api endpoint
     *
     * @return string
     */
    public function getApiEndpoint(): string
    {
        return $this->apiEndpoint;
    }

    /**
     * Provide Response
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}