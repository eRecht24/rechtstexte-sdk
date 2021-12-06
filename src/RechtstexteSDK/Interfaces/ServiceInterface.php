<?php

namespace eRecht24\RechtstexteSDK\Interfaces;

use eRecht24\RechtstexteSDK\Model\Response;

interface ServiceInterface
{
    /**
     * @return ServiceInterface
     */
    public function execute(): ServiceInterface;

    /**
     * @return string
     */
    public function getApiEndpoint(): string;

    /**
     * @return Response
     */
    public function getResponse(): Response;

    /**
     * @return mixed
     */
    public function getResult();
}