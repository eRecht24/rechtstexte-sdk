<?php
declare(strict_types=1);

use eRecht24\RechtstexteSDK\ApiClient;

use eRecht24\RechtstexteSDK\Collection;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\ClientCreateService;
use eRecht24\RechtstexteSDK\Service\ClientDeleteService;
use eRecht24\RechtstexteSDK\Service\ClientListService;
use eRecht24\RechtstexteSDK\Service\ClientUpdateService;
use PHPUnit\Framework\TestCase;

final class ClientUpdateServiceTest extends TestCase
{
    public function testShouldHandleInvalidApiKey(): void
    {
        $client = $this->getRemoteClient();
        $service = new ClientUpdateService($this->getApiClient('invalid'), $client);

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

    public function testShouldRejectInvalidPushMethod(): void
    {
        $client = $this->getRemoteClient();
        $client->fill([
            "push_method" => "invalid"
        ]);

        $service = new ClientUpdateService($this->getApiClient(), $client);

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

    public function testShouldRejectInvalidPushUri(): void
    {
        $client = $this->getRemoteClient();
        $client->fill([
            "push_uri" => null
        ]);

        $service = new ClientUpdateService($this->getApiClient(), $client);

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

    public function testShouldUpdateClient(): void
    {
        $client = $this->getRemoteClient();

        $updates = [
            'push_method' => 'PUT',
            'push_uri' => 'https://www.test.de/update',
            'cms' => 'WORDPRESS Update',
            'cms_version' => '5.7.1 Update',
            'plugin_name' => 'erecht24/apiclient',
            'author_mail' => 'update@update.de',
        ];

        $client->fill($updates);

        $service = new ClientUpdateService($this->getApiClient(), $client);

        $service->execute();
        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(true, $response->isSuccess());
        $this->assertSame(200, $response->code);

        $this->assertArrayHasKey('secret', $response->body_data);

        $updatedClient = $this->getRemoteClient();

        foreach ($updates as $key => $value)
            $this->assertSame($value, $updatedClient->$key);
    }

    private function getApiClient(
        string $key = "e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117"
    ): ApiClient
    {
        if ($key == "e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117" && getenv('ERECHT24_API_KEY') !== false) {
            $key = getenv('ERECHT24_API_KEY');
        }
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