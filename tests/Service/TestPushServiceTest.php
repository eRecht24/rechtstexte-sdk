<?php
declare(strict_types=1);

use eRecht24\RechtstexteSDK\ApiClient;

use eRecht24\RechtstexteSDK\Collection;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\ClientCreateService;
use eRecht24\RechtstexteSDK\Service\TestPushService;
use eRecht24\RechtstexteSDK\Service\ClientListService;
use PHPUnit\Framework\TestCase;

final class TestPushServiceTest extends TestCase
{
    public function testShouldHandleInvalidApiKey(): void
    {
        $client = $this->getRemoteClient();
        $service = new TestPushService($this->getApiClient('invalid'), $client->client_id);

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

    public function testShouldRejectWrongClientId(): void
    {
        $service = new TestPushService($this->getApiClient(), 1);

        $service->execute();
        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(false, $response->isSuccess());
        $this->assertSame(400, $response->code);

        $this->assertArrayHasKey('message', $response->body_data);
        $this->assertArrayHasKey('message_de', $response->body_data);
    }

    private function getApiClient(
        string $key = "e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117"
    ): ApiClient
    {
        return new ApiClient($key);
    }

    private function addDummyClient()
    {
        $clientModel = new Client([
            'push_method' => 'POST',
            'push_uri' => 'https://www.test.de',
            'cms' => 'CI',
            'plugin_name' => 'erecht24/apiclient',
        ]);

        $service = new ClientCreateService($this->getApiClient(), $clientModel);
        $service->execute();
    }

    private function getRemoteClient(): Client
    {
        $service = new ClientListService($this->getApiClient());
        /** @var Collection $collection */
        $collection = $service->execute()->getCollection();

        if ($collection->count() === 0)
            $this->addDummyClient();

        return $service->execute()->getCollection()->get(0);
    }
}