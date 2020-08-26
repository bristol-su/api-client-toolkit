<?php

namespace BristolSU\ApiToolkit;

use BristolSU\ApiToolkit\Contracts\ClientResourceGroup;
use BristolSU\ApiToolkit\Exception\ClientNotRegisteredException;

class ApiClientManager
{

    /**
     * @var array|ClientResourceGroup[]
     */
    private $resourceGroups = [];

    public function register(string $class): void
    {
        if(is_a($class, ClientResourceGroup::class, true)) {
            $this->registerMethod($class::getMethodName(), $class);
        } else {
            throw new \Exception(sprintf('Could not register client %s', $class));
        }
    }

    public function registerMethod(string $method, string $class): void
    {
        $this->resourceGroups[$method] = $class;
    }

    /**
     * @param string $name
     *
     * @return string
     *
     * @throws ClientNotRegisteredException
     */
    public function get(string $name): string
    {
        if(array_key_exists($name, $this->resourceGroups)) {
            return $this->resourceGroups[$name];
        }
        throw ClientNotRegisteredException::create($name);
    }

}
