<?php

namespace BristolSU\ApiToolkit\Concerns;

use BristolSU\ApiToolkit\Contracts\HttpClient;
use BristolSU\ApiToolkit\Response;

trait CachesResponse
{

    /**
     * @var bool
     */
    private $shouldCache = true;

    /**
     * @var bool
     */
    private $cacheDisabled = false;

    protected function cachesResponseCanHandle(HttpClient $client): bool
    {
        return true;
    }

    protected function cachesResponsePreRequest(HttpClient $httpClient, string $uri)
    {
        if($this->cacheDisabled === false) {
            $httpClient->config()->cache($this->shouldCache);
        } else {
            $httpClient->config()->cache(false);
        }
    }

    public function withCaching()
    {
        return $this->shouldCache(true);
    }

    public function withoutCaching()
    {
        return $this->shouldCache(false);
    }

    /**
     * @param bool $shouldCache
     * @return $this
     */
    public function shouldCache(bool $shouldCache)
    {
        $this->shouldCache = $shouldCache;
        return $this;
    }

    protected function disableCaching()
    {
        $this->cacheDisabled = true;
    }

}
