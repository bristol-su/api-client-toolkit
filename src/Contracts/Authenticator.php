<?php

namespace BristolSU\ApiToolkit\Contracts;

interface Authenticator
{

    public function authenticate(HttpClient $client): HttpClient;

}
