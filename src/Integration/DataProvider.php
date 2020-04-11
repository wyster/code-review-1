<?php

namespace src\Integration;

use Psr\Http\Message\ResponseInterface;

class DataProvider
{
    public function get(RequestParamsInterface $params): ResponseInterface
    {
        // returns a response from external service
    }
}