<?php
declare(strict_types=1);

namespace ERecht24;

use ERecht24\Interfaces\ServiceInterface;
use ERecht24\Model\Response;

abstract class Service implements ServiceInterface
{
    /**
     * path for url generation
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
     * @var Collection|Model|null
     */
    protected $result;

    /**
     * Service constructor.
     * @param ApiClient $apiClient
     */
    public function __construct(
        ApiClient $apiClient
    ) {
        $this->apiClient = $apiClient;
    }

    /**
     * Provide api endpoint
     * @return string
     */
    public function getApiEndpoint() : string
    {
        return $this->apiEndpoint;
    }

    /**
     * Provide Response
     * @return Response
     */
    public function getResponse(): Response
    {
        return  $this->response;
    }

}