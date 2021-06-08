<?php
declare(strict_types=1);

use ERecht24\ApiClient;

use ERecht24\Collection;
use ERecht24\Model\Client;
use ERecht24\Model\Response;
use ERecht24\Service\ClientCreateService;
use ERecht24\Service\ClientDeleteService;
use ERecht24\Service\ClientListService;
use PHPUnit\Framework\TestCase;

final class ClientListServiceTest extends TestCase
{
    public function testShouldHandleInvalidApiKey(): void
    {
        $service = new ClientListService($this->getApiClient('invalid'));

        $service->execute();
        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(false, $response->isSuccess());
        $this->assertSame(401, $response->code);

        $this->assertSame(null, $service->getCollection());

        $this->assertArrayHasKey('message', $response->body_data);
        $this->assertArrayHasKey('message_de', $response->body_data);
        $this->assertArrayHasKey('token', $response->body_data);
    }

    public function testShouldListClients(): void
    {
        $this->forceAtLeast1Client();

        $service = new ClientListService($this->getApiClient());

        $service->execute();
        $response = $service->getResponse();

        $this->assertInstanceOf(
            Response::class,
            $response
        );

        $this->assertSame(true, $response->isSuccess());
        $this->assertSame(200, $response->code);

        $this->assertTrue(count($response->body_data) > 0);
        $this->assertInstanceOf(
            Collection::class,
            $service->getCollection()
        );

        foreach ($service->getCollection() as $item) {
            $this->assertInstanceOf(
                Client::class,
                $item
            );

            $this->assertTrue(!is_null($item->client_id));
        }
    }


    private function getApiClient(
        string $key = "e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117"
    ) : ApiClient
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

    private function forceAtLeast1Client()
    {
        $service = new ClientListService($this->getApiClient());
        /** @var Collection $collection */
        $collection = $service->execute()->getCollection();

        if($collection->count() === 0)
            $this->addDummyClient();
    }
}



