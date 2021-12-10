<?php

namespace eRecht24\RechtstexteSDK\Interfaces;

use eRecht24\RechtstexteSDK\Exceptions\Exception;
use eRecht24\RechtstexteSDK\Model\Collection;
use eRecht24\RechtstexteSDK\Model\LegalText\Imprint;
use eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicy;
use eRecht24\RechtstexteSDK\Model\LegalText\PrivacyPolicySocialMedia;
use eRecht24\RechtstexteSDK\Service\EndpointService;
use eRecht24\RechtstexteSDK\Model\Client;
use eRecht24\RechtstexteSDK\Model\Response;

interface ApiInterface
{
    /**
     * @return EndpointInterface
     */
    public function getEndpointService(): EndpointInterface;

    /**
     * @return Response
     */
    public function getResponse(): Response;

    /**
     * Provide response HTTP code
     *
     * @return int|null
     */
    public function getResponseCode(): ?int;

    /**
     * Provide response body
     *
     * @return string|null
     */
    public function getResponseBody(): ?string;

    /**
     * @return array|null
     */
    public function getResponseBodyAsArray(): ?array;

    /**
     * @return bool|null
     */
    public function isLastResponseSuccess(): ?bool;

    /**
     * @param string $lang
     * @return string|null
     */
    public function getLastErrorMessage(string $lang = 'en'): ?string;

    /**
     * @return ApiInterface
     */
    public function reset(): ApiInterface;

    /**
     * @param Client $client
     * @return Client
     */
    public function createClient(Client $client): Client;

    /**
     * @param Client $client
     * @return Client
     */
    public function updateClient(Client $client): Client;

    /**
     * @param Client|int $client
     * @return bool
     */
    public function deleteClient($client): bool;

    /**
     * @return Collection|null
     */
    public function getClientList(): ?Collection;

    /**
     * @return null|Imprint
     */
    public function getImprint(): ?Imprint;

    /**
     * @return null|PrivacyPolicy
     */
    public function getPrivacyPolicy(): ?PrivacyPolicy;

    /**
     * @return null|PrivacyPolicySocialMedia
     */
    public function getPrivacyPolicySocialMedia(): ?PrivacyPolicySocialMedia;

    /**
     * @param string $lang
     * @return null|string
     */
    public function getMessage(string $lang = 'en'): ?string;

    /**
     * @param int $clientId
     * @param string $type
     * @return bool
     */
    public function fireTestPush(int $clientId, string $type = 'ping'): bool;
}