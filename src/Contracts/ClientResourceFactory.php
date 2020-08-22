<?php

namespace BristolSU\ApiToolkit\Contracts;

interface ClientResourceFactory
{

    public function create(string $class, array $arguments): ClientResource;

}
