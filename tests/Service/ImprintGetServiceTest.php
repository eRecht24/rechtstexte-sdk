<?php
declare(strict_types=1);

use ERecht24\ApiClient;

use ERecht24\Model\LegalText;
use ERecht24\Model\Response;
use ERecht24\Service\ImprintGetService;
use PHPUnit\Framework\TestCase;

final class ImprintGetServiceTest extends TestCase
{
    public function testShouldHandleInvalidApiKey(): void
    {
        $service = new ImprintGetService($this->getApiClient('invalid'));
        $service->execute();

        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(false, $response->isSuccess());
        $this->assertSame(401, $response->code);
        $this->assertSame(null, $service->getLegalText());
        $this->assertArrayHasKey('message', $response->body_data);
        $this->assertArrayHasKey('message_de', $response->body_data);
        $this->assertArrayHasKey('token', $response->body_data);
    }

    public function testShouldHandleValidApiKey(): void
    {
        $service = new ImprintGetService($this->getApiClient());
        $service->execute();

        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(200, $response->code);
        $this->assertSame(true, $response->isSuccess());
        $this->assertInstanceOf(
            LegalText::class,
            $service->getLegalText()
        );

        $this->assertArrayHasKey('html_de', $response->body_data);
        $this->assertArrayHasKey('html_en', $response->body_data);
        $this->assertArrayHasKey('created', $response->body_data);
        $this->assertArrayHasKey('modified', $response->body_data);
        $this->assertArrayHasKey('warnings', $response->body_data);
        $this->assertArrayHasKey('pushed', $response->body_data);

        $this->assertSame(LegalText::TYPE_IMPRINT, $service->getLegalText()->getType());
    }

    private function getApiClient(
        string $key = "e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117"
    ) : ApiClient
    {
        return new ApiClient($key);
    }
}



