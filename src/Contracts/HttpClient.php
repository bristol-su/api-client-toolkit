<?php

namespace BristolSU\ApiToolkit\Contracts;

use Psr\Http\Message\ResponseInterface;

interface HttpClient
{

    public function global(): \BristolSU\ApiToolkit\Contracts\HttpClientConfig;

    public function config(): \BristolSU\ApiToolkit\Contracts\HttpClientConfig;

    public function options(): array;

    public function request(string $method, string $uri): ResponseInterface;

    public function post(string $uri): ResponseInterface;

    public function get(string $uri): ResponseInterface;

    public function patch(string $uri): ResponseInterface;

    public function delete(string $uri): ResponseInterface;

    public function put(string $uri): ResponseInterface;

}
