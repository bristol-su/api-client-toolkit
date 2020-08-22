<?php

namespace BristolSU\ApiToolkit\Contracts;

abstract class ClientResourceGroup
{

    /**
     * @var ClientResourceFactory
     */
    private $clientResourceFactory;

    public function __construct(ClientResourceFactory $clientResourceFactory)
    {
        $this->clientResourceFactory = $clientResourceFactory;
    }

    public function __call($name, $arguments)
    {
        if(array_key_exists($name, static::getResources())) {
            return $this->clientResourceFactory->create(
                static::getClassFor($name), $arguments
            );
        }
    }

    abstract public static function getMethodName(): string;

    abstract public static function getResources(): array;

    protected static function getClassFor(string $name)
    {
        if (array_key_exists($name, static::getResources())) {
            return static::getResources()[$name];
        }
        throw new \Exception();
    }
}
