<?php

namespace BristolSU\ApiToolkit\Contracts;

use BristolSU\ApiToolkit\Concerns\ConvertsJson;
use BristolSU\ApiToolkit\Concerns\UsesHydration;
use BristolSU\ApiToolkit\Concerns\UsesPagination;
use BristolSU\ApiToolkit\Response;
use Psr\Http\Message\ResponseInterface;

abstract class ClientResource
{
    use ConvertsJson, UsesHydration, UsesPagination;

    /**
     * @var HttpClient
     */
    private $httpClient;

    protected $traits = [
      ConvertsJson::class => 'convertsJson',
      UsesPagination::class => 'usesPagination',
      UsesHydration::class => 'usesHydration'
    ];

    public function setClient(HttpClient $client): void
    {
        $this->httpClient = $client;
    }

    public function getClient(): HttpClient
    {
        return $this->httpClient;
    }

    protected function request($method, $uri)
    {
        $this->handlePreRequest();
        $response = $this->httpClient->request($method, $uri);
        return $this->handlePostRequest(new Response($response));
    }

    private function traits()
    {
        return array_filter(array_keys($this->traits), function($trait) {
            $method = $this->getMethod($trait, 'CanHandle');
            return method_exists($this, $method) && $this->{$method}($this->httpClient);
        });
    }

    private function handlePreRequest()
    {
        foreach ($this->traits() as $trait) {
            $method = $this->getMethod($trait, 'PreRequest');
            if (method_exists($this, $method)) {
                $this->{$method}($this->httpClient);
            }
        }
    }

    private function handlePostRequest(Response $response): Response
    {
        foreach ($this->traits() as $trait) {
            $method = $this->getMethod($trait, 'PostRequest');
            if (method_exists($this, $method)) {
                $response = $this->{$method}($response);
            }
        }
        return $response;
    }

    private function getMethod(string $trait, string $postFix = '')
    {
        return sprintf('%s%s', $this->traits[$trait], $postFix);
    }

    protected function httpGet($uri): Response
    {
        return $this->request('GET', $uri);
    }

    protected function httpPost($uri): Response
    {
        return $this->request('POST', $uri);
    }

    protected function httpPatch($uri): Response
    {
        return $this->request('PATCH', $uri);
    }

    protected function httpPut($uri): Response
    {
        return $this->request('PUT', $uri);
    }

    protected function httpDelete($uri): Response
    {
        return $this->request('DELETE', $uri);
    }

}
