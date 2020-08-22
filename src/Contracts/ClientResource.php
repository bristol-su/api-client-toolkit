<?php

namespace BristolSU\ApiToolkit\Contracts;

abstract class ClientResource
{

    /**
     * @var HttpClient
     */
    protected $httpClient;

    public function setClient(HttpClient $client): void
    {
        $this->httpClient = $client;
    }

}
