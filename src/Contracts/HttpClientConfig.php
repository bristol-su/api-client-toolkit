<?php


namespace BristolSU\ApiToolkit\Contracts;


interface HttpClientConfig
{

    public function addHeader(string $key, string $value): void;

    public function setContentType(string $contentType): void;

    public function addBody(array $body): void;

    public function addBodyElement(string $key, $element): void;

    public function toArray(): array;

    public function clear(): void;
}
