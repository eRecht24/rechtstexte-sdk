<?php


namespace ERecht24\Interfaces;


interface ServiceInterface
{
    public function execute() : ServiceInterface;

    public function getApiEndpoint() : string;

    public function getResponse();

    public function getResponseArray() : array;

    public function getResponseJson() : string;

    public function getResponseCode() : int;
}