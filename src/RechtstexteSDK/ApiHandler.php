<?php
declare(strict_types=1);

namespace eRecht24\RechtstexteSDK;

use eRecht24\RechtstexteSDK\Exceptions\Exception;
use eRecht24\RechtstexteSDK\Interfaces\ApiInterface;
use eRecht24\RechtstexteSDK\Interfaces\EndpointInterface;
use eRecht24\RechtstexteSDK\Model\Collection;
use eRecht24\RechtstexteSDK\Model\LegalText\Imprint;
use eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicy;
use eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicySocialMedia;
use eRecht24\RechtstexteSDK\Service\EndpointService;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;

class ApiHandler implements ApiInterface
{
    /**
     * @var EndpointService
     */
    private $endpointService;

    /**
     * @var Response
     */
    protected $response;

    /**
     * ApiClient constructor.
     *
     * @param string $apiKey
     * @throws Exception
     */
    public function __construct(string $apiKey)
    {
        $this->endpointService = new EndpointService($apiKey);
    }

    /**
     * @return EndpointInterface
     */
    public function getEndpointService(): EndpointInterface
    {
        return $this->endpointService;
    }

    /**
     * Provide response
     *
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * Provide last error message
     *
     * @param string $lang
     * @return string|null
     */
    public function getLastErrorMessage(string $lang = 'en'): ?string
    {
        if ($this->response instanceof Response) {
            return $this->response->getErrorMessage($lang);
        }

        return null;
    }

    /**
     * @return ApiInterface
     */
    public function reset(): ApiInterface
    {
        $this->response = null;

        return $this;
    }

    /**
     * ClientCreateService
     *
     * @param Client $client
     * @return Client
     * @throws Exception
     */
    public function createClient(Client $client): Client
    {
        $this->response = $this->endpointService->executeService(
            'client_create',
            [],
            $client->getAttributes()
        );

        if ($this->response->isSuccess()) {
            $client->setSecret($this->response->getBodyDataByKey('secret'));
            $client->setClientId($this->response->getBodyDataByKey('client_id'));
        }

        return $client;
    }

    /**
     * ClientUpdateService
     *
     * @param Client $client
     * @return Client
     * @throws Exception
     */
    public function updateClient(Client $client): Client
    {
        $this->response = $this->endpointService->executeService(
            'client_update',
            [$client->getClientId()],
            $client->getAttributes()
        );

        if ($this->response->isSuccess()) {
            $client->setSecret($this->response->getBodyDataByKey('secret'));
        }

        return $client;
    }

    /**
     * ClientDeleteService
     *
     * @param Client|int $client
     * @return bool
     * @throws Exception
     */
    public function deleteClient($client): bool
    {
        if ($client instanceof Client) {
            $this->response = $this->endpointService->executeService(
                'client_delete',
                [$client->getClientId()]
            );
        } else {
            $this->response = $this->endpointService->executeService(
                'client_delete',
                [$client]
            );
        }


        return $this->response->isSuccess();
    }

    /**
     * ClientListService
     *
     * @return Collection|null
     * @throws Exception
     */
    public function getClientList(): ?Collection
    {
        $this->response = $this->endpointService->executeService('client_list');

        if ($this->response->isSuccess()) {
            $result = new Collection();
            foreach ($this->response->getBodyDataAsArray() as $clientData) {
                $result->add(new Client($clientData));
            }

            return $result;
        }

        return null;
    }

    /**
     * ImprintGetService
     *
     * @return null|Imprint
     * @throws Exception
     */
    public function getImprint(): ?Imprint
    {
        $this->response = $this->endpointService->executeService('imprint_get');

        if ($this->response->isSuccess()) {
            return new Imprint($this->response->getBodyDataAsArray());
        }

        return null;
    }

    /**
     * PrivacyPolicyGetService
     *
     * @return null|PrivacyPolicy
     * @throws Exception
     */
    public function getPrivacyPolicy(): ?PrivacyPolicy
    {
        $this->response = $this->endpointService->executeService('private_policy_get');

        if ($this->response->isSuccess()) {
            return new PrivacyPolicy($this->response->getBodyDataAsArray());
        }

        return null;
    }

    /**
     * PrivacyPolicySocialMediaGetService
     *
     * @return null|PrivacyPolicySocialMedia
     * @throws Exception
     */
    public function getPrivacyPolicySocialMedia(): ?PrivacyPolicySocialMedia
    {
        $this->response = $this->endpointService->executeService('private_policy_social_get');

        if ($this->response->isSuccess()) {
            return new PrivacyPolicySocialMedia($this->response->getBodyDataAsArray());
        }

        return null;
    }

    /**
     * MessageGetService
     *
     * @param string $lang
     * @return null|string
     * @throws Exception
     */
    public function getMessage(string $lang = 'en'): ?string
    {
        $this->response = $this->endpointService->executeService('message_get');

        if ($this->response->isSuccess()) {
            return $this->response->getMessage($lang);
        }

        return null;
    }

    /**
     * TestPushService
     *
     * @param int $clientId
     * @param string $type
     * @return bool
     * @throws Exception
     */
    public function fireTestPush(int $clientId, string $type = 'ping'): bool
    {
        $this->response = $this->endpointService->executeService(
            'test_push',
            [$clientId],
            ['type' => $type]
        );

        return $this->response->isSuccess();
    }
}