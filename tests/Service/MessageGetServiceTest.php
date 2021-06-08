<?php
declare(strict_types=1);

use ERecht24\ApiClient;

use ERecht24\Model\Response;
use ERecht24\Service\MessageGetService;
use PHPUnit\Framework\TestCase;

final class MessageGetServiceTest extends TestCase
{
    public function testShouldHandleInvalidApiKey(): void
    {
        $service = new MessageGetService($this->getApiClient('invalid'));
        $service->execute();

        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(false, $response->isSuccess());
        $this->assertSame(401, $response->code);

        $this->assertArrayHasKey('message', $response->body_data);
        $this->assertArrayHasKey('message_de', $response->body_data);
        $this->assertArrayHasKey('token', $response->body_data);
    }

    public function testShouldHandleValidApiKey(): void
    {
        $service = new MessageGetService($this->getApiClient());
        $service->execute();

        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(200, $response->code);
        $this->assertSame(true, $response->isSuccess());

        $this->assertArrayHasKey('message', $response->body_data);
        $this->assertArrayHasKey('message_de', $response->body_data);
        $this->assertArrayHasKey('call2action', $response->body_data);
        $this->assertArrayHasKey('call2action_de', $response->body_data);
        $this->assertArrayHasKey('link', $response->body_data);
    }

    private function getApiClient(
        string $key = "e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117"
    ) : ApiClient
    {
        return new ApiClient($key);
    }
}



