<?php
declare(strict_types=1);

namespace ERecht24;

use ERecht24\Model\Response;

class ApiClient
{
    const API_SCHEME = "https";
    const API_HOST = "api.e-recht24.de";

    const HTTP_GET = "GET";
    const HTTP_POST = "POST";
    const HTTP_PUT = "PUT";
    const HTTP_DELETE = "DELETE";

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $postFields;

    /**
     * Client constructor.
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Make cURL request
     * @return Response
     * @throws Exception
     */
    public function makeRequest() : Response
    {
        $this->cURLcheckBasicFunctions();

        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $this->getFullUrl());
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_ENCODING, "");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST , $this->getMethod());
            curl_setopt($ch, CURLOPT_HTTPHEADER , [
                "cache-control: no-cache",
                "content-type: application/json",
                sprintf("eRecht24: %s", $this->getApiKey())
            ]);

            if (!empty($this->getPostFields()))
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($this->getPostFields()));

            $response = curl_exec($ch);
            $httpCode = intval(curl_getinfo($ch, CURLINFO_HTTP_CODE));

            // close curl resource to free up system resources
            curl_close($ch);
        } catch (\Exception $e) {
            throw new Exception(
                sprintf('Unable to make Request. %s', $e->getMessage()),
                500,
                $e
            );
        }

        return new Response([
            'code' => $httpCode,
            'body' => $response
        ]);
    }

    /**
     * Provide API key for Authorisation
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Function provides full url for cURL
     * @throws Exception
     */
    public function getFullUrl() : string
    {
        if(function_exists('http_build_url'))
            return http_build_url(self::API_HOST, [
                "scheme" => self::API_SCHEME,
                "host" =>  self::API_HOST,
                "path" => $this->getPath(),
            ]);

        return sprintf('%s://%s%s',
            self::API_SCHEME,
            self::API_HOST,
            $this->getPath()
        );
    }

    /**
     * Set HTTP method for cURL
     * @param string $method
     * @return ApiClient
     * @throws Exception
     */
    public function setMethod(
        string $method
    ): ApiClient
    {
        if (!in_array($method, [self::HTTP_GET, self::HTTP_POST, self::HTTP_PUT, self::HTTP_DELETE]))
            throw new Exception('Invalid HTTP method specified.');

        $this->method = $method;

        return $this;
    }

    /**
     * Provide HTTP method for cURL
     * @return string
     * @throws Exception
     */
    public function getMethod(): string
    {
        if(!$this->method)
            throw new Exception('Http Method not set');

        return $this->method;
    }

    /**
     * Set Path for url generation
     * @param string $path
     * @return ApiClient
     */
    public function setPath(
        string $path
    ): ApiClient
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Provide path for url generation
     * @return string
     * @throws Exception
     */
    public function getPath(): string
    {
        if(!$this->path)
            throw new Exception('Url path not set');

        return $this->path;
    }

    /**
     * Set Post fields for Request
     * @param array $postFields
     * @return ApiClient
     */
    public function setPostFields(
        array $postFields
    ): ApiClient
    {
        $this->postFields = $postFields;

        return $this;
    }

    /**
     * Provide post fields for Request
     * @return ?array
     */
    public function getPostFields(): ?array
    {
        return $this->postFields;
    }

    /**
     * Check needed functions
     * @throws Exception
     */
    private function cURLcheckBasicFunctions()
    {
        if( !function_exists("curl_init") ||
            !function_exists("curl_setopt") ||
            !function_exists("curl_exec") ||
            !function_exists("curl_close") )
            throw new Exception('Required cURL Functions does not exist');
    }
}