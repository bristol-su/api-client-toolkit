<?php

namespace BristolSU\ApiToolkit;

use BristolSU\ApiToolkit\Hydration\HydrationModel;
use Exception;
use Psr\Http\Message\ResponseInterface;

/**
 * Represents a response from an HTTP client
 *
 * @property int current_page Get the current page
 * @property int records_from Get the number of the first record on the page
 * @property int records_to Get the number of the last record on the page
 * @property int last_page Get the last page number
 * @property int per_page Get the number of rows per page
 * @property int total_records Get the total number of records
 */
class Response
{

    /**
     * Holds any custom attributes set on the response
     *
     * @var array
     */
    private $attributes = [];

    /**
     * Holds the set body of the response
     *
     * @var array|HydrationModel|null
     */
    private $body;

    /**
     * Holds the underlying psr response
     *
     * @var ResponseInterface
     */
    private $response;

    /**
     * @param ResponseInterface $response The underlying psr response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get the underlying psr response
     *
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    /**
     * Get the body from the underlying psr response
     *
     * @return string
     */
    public function getResponseBody(): string
    {
        return (string) $this->getResponse()->getBody();
    }

    /**
     * Set the body on the response.
     *
     * This does not affect the underlying response.
     * The body must either be an array, or a HydrationModel
     *
     * @param array|HydrationModel|null $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * Gets the custom body for the response.
     *
     * This does not affect the underlying response.
     *
     * @return array|HydrationModel|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Dynamically set an attribute on the response
     *
     * @param string $key The attribute key
     * @param mixed $value The value of the attribute
     */
    public function __set(string $key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Get a dynamically set attribute on the response
     *
     * @param string $key Attribute to get
     * @return mixed Return the attribute
     *
     * @throws Exception If the property does not exist
     */
    public function __get(string $key)
    {
        if(array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
        throw new Exception(sprintf('Property %s does not exist on the response class %s.', $key, Response::class));
    }



}
