<?php

namespace BristolSU\ApiToolkit;

class HttpClientConfig
{

    private $headers = [];

    private $body = [];

    private $query = [];

    private $shouldCache = true;

    private $verify = true;

    public function addHeaders(array $headers)
    {
        $this->headers = array_merge(
          $this->headers, $headers
        );
    }

    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function getHeader(string $key, $default = null)
    {
        return (
        array_key_exists($key, $this->headers) ? $this->headers[$key] : $default
        );
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function addBody(array $body): void
    {
        $this->body = array_merge(
          $this->body, $body
        );
    }

    public function addBodyElement(string $key, $value): void
    {
        $this->body[$key] = $value;
    }

    public function getBodyElement(string $key, $default = null)
    {
        return (
        array_key_exists($key, $this->body) ? $this->body[$key] : $default
        );
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function addQuery(array $query): void
    {
        $this->query = array_merge(
          $this->query, $query
        );
    }

    public function addQueryElement(string $key, $value): void
    {
        $this->query[$key] = $value;
    }

    public function getQueryElement(string $key, $default = null)
    {
        return (
        array_key_exists($key, $this->query) ? $this->query[$key] : $default
        );
    }

    public function getQuery(): array
    {
        return $this->query;
    }

    public function cache(bool $shouldCache): void
    {
        $this->shouldCache = $shouldCache;
    }

    public function shouldCache(): bool
    {
        return $this->shouldCache;
    }

    public function verifySSL(bool $verify)
    {
        $this->verify = $verify;
    }

    public function shouldVerifySSL(): bool
    {
        return $this->verify;
    }

    public function toArray(): array
    {
        return [
          'headers' => $this->headers,
          'body' => $this->body,
          'query' => $this->query,
          'shouldCache' => $this->shouldCache,
          'verify' => $this->verify
        ];
    }

    public function merge(HttpClientConfig $config)
    {
        $firstArray = $this->toArray();
        $secondArray = $config->toArray();
        return static::fromArray(
          $this->arrayMergeRecursiveDistinct($firstArray, $secondArray)
        );
    }

    private function arrayMergeRecursiveDistinct(array &$array1, array &$array2) {
        $merged = $array1;

        foreach ( $array2 as $key => &$value )
        {
            if ( is_array ( $value ) && isset ( $merged [$key] ) && is_array ( $merged [$key] ) )
            {
                $merged [$key] = $this->arrayMergeRecursiveDistinct( $merged [$key], $value );
            }
            else
            {
                $merged [$key] = $value;
            }
        }

        return $merged;
    }

    public static function fromArray(array $array): self
    {
        $config = new static();
        $config->addHeaders($array['headers']);
        $config->addBody($array['body']);
        $config->addQuery($array['query']);
        $config->cache($array['shouldCache']);
        $config->verifySSL($array['verify']);
        return $config;
    }

    public function clear(): void
    {
        $this->headers = [];
        $this->body = [];
        $this->query = [];
        $this->shouldCache = true;
    }
}
