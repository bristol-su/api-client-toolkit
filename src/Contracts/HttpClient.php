<?php

namespace BristolSU\ApiToolkit\Contracts;

use Psr\Http\Client\ClientInterface;

interface HttpClient
{

    public function addHeader(string $key, string $value): void;

    public function setBaseUrl(string $baseUrl): void;

    public function addBody(array $body): void;

    public function addBodyElement(string $key, $element): void;
}
