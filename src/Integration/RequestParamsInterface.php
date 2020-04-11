<?php declare(strict_types=1);

namespace src\Integration;

interface RequestParamsInterface
{
    public function getHost(): string;
    public function getUser(): string;
    public function getPassword(): string;
    public function getData(): array;
}