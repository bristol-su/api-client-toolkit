<?php

namespace BristolSU\ApiToolkit\Exception;

class ClientNotRegisteredException extends \Exception
{

    public static function create(string $clientName)
    {
        return new static(
          sprintf('The client %s has not been registered', $clientName),
          500
        );
    }

}
