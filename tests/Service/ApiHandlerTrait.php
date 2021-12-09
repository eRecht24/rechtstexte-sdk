<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK\Tests\Service;

use eRecht24\RechtstexteSDK\ApiHandler;
use eRecht24\RechtstexteSDK\Exceptions\Exception;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Collection;
use eRecht24\RechtstexteSDK\Model\Response;

trait ApiHandlerTrait
{
    /**
     * @param string $key
     * @return ApiHandler
     * @throws Exception
     */
    public function getApiHandler(
        string $key = 'e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117'
    ): ApiHandler
    {
        if ('e81cbf18a5239377aa4972773d34cc2b81ebc672879581bce29a0a4c414bf117' == $key
            &&
            false !== getenv('ERECHT24_API_KEY')
        ) {
            $key = getenv('ERECHT24_API_KEY');
        }

        return new ApiHandler($key);
    }

    /**
     * @param ApiHandler $handler
     * @return Client
     * @throws Exception
     */
    public function getRemoteClient(ApiHandler $handler): Client
    {
        $collection = $handler->getClientList();

        if ($collection instanceof Collection) {
            if ($collection->isEmpty())
                return $this->addDummyClient($handler);

            return $collection->first();
        }

        return new Client();
    }

    /**
     * @param ApiHandler $handler
     * @return Client
     * @throws Exception
     */
    public function addDummyClient(ApiHandler $handler): Client
    {
        return $handler->createClient(new Client([
            'push_method' => 'POST',
            'push_uri' => 'https://unit.test.tv/channel/push',
            'cms' => 'JML4',
            'cms_version' => '4.2.17',
            'plugin_name' => 'erecht24/rechtstexte-sdk',
            'author_mail' => 'testi.testman@test.tv',
        ]));
    }

    /**
     * @param ApiHandler $handler
     * @return void
     * @throws Exception
     */
    public function forceAtLeastOneClient(ApiHandler $handler)
    {
        $collection = $handler->getClientList();

        if ($collection instanceof Collection) {
            if ($collection->isEmpty()) {
                $this->addDummyClient($handler);
            }
        }
    }

    /**
     * @param ApiHandler $handler
     * @return void
     * @throws Exception
     */
    public function forceExactTwoClients(ApiHandler $handler)
    {
        $collection = $handler->getClientList();

        if (!($collection instanceof Collection)) {
            return;
        }

        switch ($collection->count()) {
            case 0:
                $this->addDummyClient($handler);
                $this->addDummyClient($handler);
                break;

            case 1:
                $this->addDummyClient($handler);
                break;

            case 2:
                break;

            case 3:
                $this->removeDummyClient($handler, $collection->get(0));
        }
    }

    /**
     * @param ApiHandler $handler
     * @param Client $client
     * @return void
     * @throws Exception
     */
    public function removeDummyClient(ApiHandler $handler, Client $client)
    {
        $handler->deleteClient($client->getClientId());
    }

    /**
     * @param ApiHandler $handler
     * @return Client
     * @throws Exception
     */
    public function getNewestClient(ApiHandler $handler): Client
    {
        $collection = $handler->getClientList();

        if ($collection instanceof Collection) {
            if ($collection->isEmpty())
                return $this->addDummyClient($handler);

            return $collection->last();
        }

        return new Client();
    }
}