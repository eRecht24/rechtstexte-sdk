<?php

namespace ERecht24\Interfaces;

use ERecht24\Model\Response;

interface ServiceInterface
{
    public function execute() : ServiceInterface;

    public function getApiEndpoint() : string;

    public function getResponse() : Response;
}