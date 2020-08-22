<?php

namespace BristolSU\ApiToolkit\Contracts;

interface ClientResourceGroupFactory
{

    public function create(string $class): ClientResourceGroup;

}
