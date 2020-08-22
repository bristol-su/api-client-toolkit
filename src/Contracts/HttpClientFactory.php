<?php

namespace BristolSU\ApiToolkit\Contracts;

use Psr\Http\Client\ClientInterface;

interface HttpClientFactory
{

    public static function create(ClientInterface $client, string $baseUrl): HttpClient;

}
