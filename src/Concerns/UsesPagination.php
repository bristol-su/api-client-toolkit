<?php

namespace BristolSU\ApiToolkit\Concerns;

use BristolSU\ApiToolkit\Contracts\HttpClient;
use BristolSU\ApiToolkit\Response;
use Psr\Http\Message\ResponseInterface;

trait UsesPagination
{

    private $page = 1;

    private $perPage = 10;

    private $usePagination = false;

    private $pageKey = 'page';

    private $perPageKey = 'per_page';

    public function page(int $page = 1)
    {
        $this->page = $page;
        return $this;
    }

    public function perPage(int $perPage = 10)
    {
        $this->perPage = $perPage;
        return $this;
    }

    protected function paginationPageKey(string $key = 'page')
    {
        $this->pageKey = $key;
    }

    protected function paginationPerPageKey(string $key = 'per_page')
    {
        $this->perPageKey = $key;
    }

    protected function usesPagination()
    {
        $this->usePagination = true;
    }

    protected function usesPaginationCanHandle(HttpClient $client): bool
    {
        return $this->usePagination;
    }

    protected function usesPaginationPreRequest(HttpClient $client, string $uri)
    {
        $client->config()->addQuery([
          $this->pageKey => $this->page,
          $this->perPageKey => $this->perPage
        ]);
    }

    protected function usesPaginationPostRequest(Response $response)
    {
        $body = $response->getBody();
        $response->current_page = $body['current_page'];
        $response->records_from = $body['from'];
        $response->last_page = $body['last_page'];
        $response->per_page = $body['per_page'];
        $response->records_to = $body['to'];
        $response->total_records = $body['total'];
        $response->setBody($body['data']);
        return $response;
    }

}
