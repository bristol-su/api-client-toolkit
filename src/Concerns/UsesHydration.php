<?php

namespace BristolSU\ApiToolkit\Concerns;

use BristolSU\ApiToolkit\Contracts\HttpClient;
use BristolSU\ApiToolkit\Hydration\Hydrate;
use BristolSU\ApiToolkit\Hydration\Hydrator;
use BristolSU\ApiToolkit\Response;
use Psr\Http\Message\ResponseInterface;

trait UsesHydration
{

    private $useHydration = false;

    private $hydrate = null;

    protected function hydrate(Hydrate $hydrate)
    {
        $this->hydrate = $hydrate;
    }

    protected function usesHydrationCanHandle(HttpClient $client): bool
    {
        return $this->hydrate !== null;
    }

    protected function usesHydrationPostRequest(Response $response)
    {
        $models = Hydrator::hydrate($response->getBody(), $this->hydrate);
        $response->setBody($models);
        return $response;
    }

}
