<?php

namespace src\Integration;

use Psr\Http\Message\ResponseInterface;

class DataProvider
{
    protected function get(RequestParamsInterface $params): ResponseInterface
    {
        // returns a response from external service
    }
}