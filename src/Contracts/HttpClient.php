<?php

namespace BristolSU\ApiToolkit\Contracts;

use BristolSU\ApiToolkit\HttpClientConfig;
use Psr\Http\Message\ResponseInterface;

interface HttpClient
{

    public function global(): HttpClientConfig;

    public function config(): HttpClientConfig;

    public function mergedConfig(): HttpClientConfig;

    public function options(): array;

    public function request(string $method, string $uri): ResponseInterface;

    public function post(string $uri): ResponseInterface;

    public function get(string $uri): ResponseInterface;

    public function patch(string $uri): ResponseInterface;

    public function delete(string $uri): ResponseInterface;

    public function put(string $uri): ResponseInterface;

}
