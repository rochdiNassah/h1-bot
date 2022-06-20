<?php declare(strict_types=1);

namespace Automation\Core\Http;

interface RequestInterface
{
    public function method(): string;

    public function headers(): array;

    public function uri(): string;

    public function path(): string;
}