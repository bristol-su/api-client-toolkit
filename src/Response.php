<?php

namespace BristolSU\ApiToolkit;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Response
 * @property int current_page Get the current page
 * @property int records_from Get the number of the first record on the page
 * @property int records_to Get the number of the last record on the page
 * @property int last_page Get the last page number
 * @property int per_page Get the number of rows per page
 * @property int total_records Get the total number of records
 */
class Response
{

    private $attributes = [];

    private $body = [];

    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function getResponseBody()
    {
        return (string) $this->getResponse()->getBody();
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function __set(string $key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get(string $key)
    {
        if(array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        return null;
    }



}
