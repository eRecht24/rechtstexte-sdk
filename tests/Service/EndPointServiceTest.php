<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests\Service;

use eRecht24\RechtstexteSDK\Exceptions\Exception as ERecht24Exception;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\EndpointService;
use PHPUnit\Framework\TestCase;

final class EndPointServiceTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $service = new EndpointService('test');
        $this->assertInstanceOf(
            EndpointService::class,
            $service
        );
    }

    public function testUseGetAsDefaultMethod(): void
    {
        $service = new EndpointService('test');
        $this->assertSame(EndpointService::HTTP_GET, $service->getMethod());
    }

    public function testCanSetValidHTTPMethod(): void
    {
        $client = new EndpointService('test');

        $client->setMethod(EndpointService::HTTP_POST);
        $this->assertSame(EndpointService::HTTP_POST, $client->getMethod());

        $client->setMethod(EndpointService::HTTP_PUT);
        $this->assertSame(EndpointService::HTTP_PUT, $client->getMethod());

        $client->setMethod(EndpointService::HTTP_DELETE);
        $this->assertSame(EndpointService::HTTP_DELETE, $client->getMethod());

        $client->setMethod(EndpointService::HTTP_GET);
        $this->assertSame(EndpointService::HTTP_GET, $client->getMethod());
    }

    public function testCanNotSetInvalidHTTPMethod(): void
    {
        $client = new EndpointService('test');

        $this->expectException(ERecht24Exception::class);
        $client->setMethod('Not valid');
    }

    public function testUseSlashAsDefaultPath(): void
    {
        $client = new EndpointService('test');
        $this->assertSame('/', $client->getPath());
    }

    public function testCanNotUnsetPath(): void
    {
        $client = new EndpointService('test');
        $client->setPath('');
        $this->assertSame('/', $client->getPath());
    }

    public function testPathSlashIsAutomaticallyAdded(): void
    {
        $client = new EndpointService('test');

        $client->setPath('test');

        $this->assertSame('/test', $client->getPath());
    }

    public function testCanMakeRequest(): void
    {
        $client = new EndpointService('test');
        $response = $client->makeRequest(
            '/v1/clients',
            EndpointService::HTTP_GET
        );

        $this->assertInstanceOf(
            Response::class,
            $response
        );
    }
}