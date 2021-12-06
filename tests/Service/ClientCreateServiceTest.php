<?php
declare(strict_types=1);

use eRecht24\RechtstexteSDK\ApiClient;

use eRecht24\RechtstexteSDK\Collection;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;
use eRecht24\RechtstexteSDK\Service\ClientCreateService;
use eRecht24\RechtstexteSDK\Service\ClientDeleteService;
use eRecht24\RechtstexteSDK\Service\ClientListService;
use PHPUnit\Framework\TestCase;

final class ClientCreateServiceTest extends TestCase
{
    public function testShouldHandleInvalidApiKey(): void
    {
        $client = new Client();
        $service = new ClientCreateService($this->getApiClient('invalid'), $client);

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

    public function test400ForInvalidHTTPMethod(): void
    {
        $this->force2Clients();

        $client = new Client([
            'push_method' => 'INVALID',
            'push_uri' => 'https://www.test.de',
            'cms' => 'CI',
            'plugin_name' => 'erecht24/apiclient',
        ]);

        $service = new ClientCreateService($this->getApiClient(), $client);

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

    public function test400ForMissingPushUri(): void
    {
        $this->force2Clients();

        $client = new Client([
            'push_method' => 'GET',
            'cms' => 'CI',
            'plugin_name' => 'erecht24/apiclient',
        ]);

        $service = new ClientCreateService($this->getApiClient(), $client);

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

    public function testCanCreateNewClientWithClientModel(): void
    {
        $this->force2Clients();

        $data = [
            'push_method' => 'GET',
            'push_uri' => 'https://www.test.de',
            'cms' => 'CI',
            'plugin_name' => 'erecht24/apiclient',
        ];

        $client = new Client($data);
        $service = new ClientCreateService($this->getApiClient(), $client);

        $service->execute();
        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(true, $response->isSuccess());
        $this->assertSame(200, $response->code);

        $this->assertArrayHasKey('secret', $response->body_data);
        $this->assertArrayHasKey('client_id', $response->body_data);

        $createdClient = $this->getNewestClient();
        foreach ($data as $key => $value)
            $this->assertSame($value, $createdClient->$key);
    }

    public function testCanCreateNewClientWithArray(): void
    {
        $this->force2Clients();

        $data = [
            'push_method' => 'GET',
            'push_uri' => 'https://www.test.de',
            'cms' => 'CI',
            'plugin_name' => 'erecht24/apiclient',
        ];

        $service = new ClientCreateService($this->getApiClient(), $data);

        $service->execute();
        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(true, $response->isSuccess());
        $this->assertSame(200, $response->code);

        $this->assertArrayHasKey('secret', $response->body_data);
        $this->assertArrayHasKey('client_id', $response->body_data);

        $createdClient = $this->getNewestClient();
        foreach ($data as $key => $value)
            $this->assertSame($value, $createdClient->$key);
    }

    public function testCanNotCreateMoreThan3Clients(): void
    {
        $this->force2Clients();
        $this->addDummyClient();

        $client = new Client([
            'push_method' => 'GET',
            'push_uri' => 'https://www.test.de',
            'cms' => 'CI',
            'plugin_name' => 'erecht24/apiclient',
        ]);

        $service = new ClientCreateService($this->getApiClient(), $client);

        $service->execute();
        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(false, $response->isSuccess());
        $this->assertSame(403, $response->code);

        $this->assertArrayHasKey('message', $response->body_data);
        $this->assertArrayHasKey('message_de', $response->body_data);
    }

    private function force2Clients()
    {
        $service = new ClientListService($this->getApiClient());
        /** @var Collection $collection */
        $collection = $service->execute()->getCollection();
        switch ($collection->count()) {
            case 0 :
                $this->addDummyClient();
                $this->addDummyClient();
                return;
            case 1 :
                $this->addDummyClient();
                return;
            case 2 :
                return;
            case 3 :
                $this->removeDummyClient($collection->get(0));
                return;
        }
    }

    private function getNewestClient(): Client
    {
        $service = new ClientListService($this->getApiClient());
        /** @var Collection $collection */
        $collection = $service->execute()->getCollection();

        return $collection->last();
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

    private function removeDummyClient(
        Client $client
    )
    {
        $deleteService = new ClientDeleteService($this->getApiClient(), $client->client_id);
        $deleteService->execute();
    }
}