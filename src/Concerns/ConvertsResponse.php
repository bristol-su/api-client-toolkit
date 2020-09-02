<?php

namespace BristolSU\ApiToolkit\Concerns;

use BristolSU\ApiToolkit\Contracts\HttpClient;
use BristolSU\ApiToolkit\Response;

trait ConvertsResponse
{

    /**
     * @var string
     */
    private $type;

    protected function convertsResponseCanHandle(HttpClient $client): bool
    {
        $this->type = $client->mergedConfig()->getHeader('Accept', null);
        return true;
    }

    protected function convertsResponsePostRequest(Response $response)
    {
        $content = [];

        switch (strtolower($this->type)) {
            case 'application/json':
                $content = $this->convertJson($response);
                break;
            default:
                throw new \Exception(sprintf('Content type %s not understood.', strtolower($this->type)));
        }

        $response->setBody($content);
        return $response;
    }

    private function convertJson(Response $response): array
    {
        return json_decode((string) $response->getResponse()->getBody(), true);
    }


}
