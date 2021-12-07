<?php
declare(strict_types=1);

use eRecht24\RechtstexteSDK\ApiClient;
use eRecht24\RechtstexteSDK\Exception as ERecht24Exception;
use eRecht24\RechtstexteSDK\Model\Response;
use PHPUnit\Framework\TestCase;

final class ApiClientTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $client = new ApiClient('test');
        $this->assertInstanceOf(
            ApiClient::class,
            $client
        );
    }

    public function testUseGetAsDefaultMethod(): void
    {
        $client = new ApiClient('test');
        $this->assertSame(ApiClient::HTTP_GET, $client->getMethod());
    }

    public function testCanSetValidHTTPMethod(): void
    {
        $client = new ApiClient('test');

        $client->setMethod(ApiClient::HTTP_POST);
        $this->assertSame(ApiClient::HTTP_POST, $client->getMethod());

        $client->setMethod(ApiClient::HTTP_PUT);
        $this->assertSame(ApiClient::HTTP_PUT, $client->getMethod());

        $client->setMethod(ApiClient::HTTP_DELETE);
        $this->assertSame(ApiClient::HTTP_DELETE, $client->getMethod());

        $client->setMethod(ApiClient::HTTP_GET);
        $this->assertSame(ApiClient::HTTP_GET, $client->getMethod());
    }

    public function testCanNotSetInvalidHTTPMethod(): void
    {
        $client = new ApiClient('test');

        $this->expectException(ERecht24Exception::class);
        $client->setMethod('Not valid');
    }

    public function testUseSlashAsDefaultPath(): void
    {
        $client = new ApiClient('test');
        $this->assertSame('/', $client->getPath());
    }

    public function testCanNotUnsetPath(): void
    {
        $client = new ApiClient('test');
        $client->setPath('');
        $this->assertSame('/', $client->getPath());
    }

    public function testPathSlashIsAutomaticallyAdded(): void
    {
        $client = new ApiClient('test');

        $client->setPath('test');

        $this->assertSame('/test', $client->getPath());
    }

    public function testCanMakeRequest(): void
    {
        $client = new ApiClient('test');
        $response = $client->makeRequest();

        $this->assertInstanceOf(
            Response::class,
            $response
        );
    }
}