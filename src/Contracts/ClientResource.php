<?php

namespace BristolSU\ApiToolkit\Contracts;

use BristolSU\ApiToolkit\Concerns\CachesResponse;
use BristolSU\ApiToolkit\Concerns\ConvertsResponse;
use BristolSU\ApiToolkit\Concerns\UsesHydration;
use BristolSU\ApiToolkit\Concerns\UsesModuleUrl;
use BristolSU\ApiToolkit\Concerns\UsesPagination;
use BristolSU\ApiToolkit\Response;
use Psr\Http\Message\ResponseInterface;

abstract class ClientResource
{
    use ConvertsResponse, UsesHydration, UsesPagination, UsesModuleUrl, CachesResponse;

    protected $traits = [
      ConvertsResponse::class => 'convertsResponse',
      UsesPagination::class => 'usesPagination',
      UsesHydration::class => 'usesHydration',
      CachesResponse::class => 'cachesResponse',
      UsesModuleUrl::class => 'usesModuleUrl'
    ];

    /**
     * @var HttpClient
     */
    private $httpClient;

    public function setClient(HttpClient $client): void
    {
        $this->httpClient = $client;
    }

    public function getClient(): HttpClient
    {
        return $this->httpClient;
    }

    protected function httpGet($uri): Response
    {
        return $this->request('GET', $uri);
    }

    protected function request($method, $uri)
    {
        $uri = $this->handlePreRequest($uri);
        $response = $this->httpClient->request($method, $uri);
        return $this->handlePostRequest(new Response($response));
    }

    private function handlePreRequest(string $uri)
    {
        foreach ($this->traits() as $trait) {
            $method = $this->getMethod($trait, 'PreRequest');
            if (method_exists($this, $method)) {
                $response = $this->{$method}($this->httpClient, $uri);
                if (is_string($response)) {
                    $uri = $response;
                }
            }
        }
        return $uri;
    }

    private function traits()
    {
        return array_filter(array_keys($this->traits), function ($trait) {
            $method = $this->getMethod($trait, 'CanHandle');
            return method_exists($this, $method) && $this->{$method}($this->httpClient);
        });
    }

    private function getMethod(string $trait, string $postFix = '')
    {
        return sprintf('%s%s', $this->traits[$trait], $postFix);
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

    protected function addTool(string $alias, string $class)
    {
        $this->traits[$class] = $alias;
    }
}
