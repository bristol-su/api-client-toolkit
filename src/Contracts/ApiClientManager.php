<?php

namespace BristolSU\ApiToolkit\Contracts;

use BristolSU\ApiToolkit\Exception\ClientNotRegisteredException;

interface ApiClientManager
{

    public function registerMethod(string $method, string $class): void;

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws ClientNotRegisteredException
     */
    public function get(string $name): string;

}
