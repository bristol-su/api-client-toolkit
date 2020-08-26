<?php

namespace BristolSU\ApiToolkit\Concerns;

use BristolSU\ApiToolkit\Contracts\HttpClient;
use BristolSU\ApiToolkit\Response;

trait ConvertsJson
{

    protected function convertsJsonCanHandle(HttpClient $client): bool
    {
        return $client->mergedConfig()->getHeader('Accept') === 'application/json';
    }

    protected function convertsJsonPostRequest(Response $response)
    {
        $content = json_decode((string) $response->getResponse()->getBody(), true);
        $response->setBody($content);
        return $response;
    }


}
