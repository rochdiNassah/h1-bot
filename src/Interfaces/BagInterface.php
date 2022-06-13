<?php declare(strict_types=1);

namespace Automation\Interfaces;

interface BagInterface
{
    public function has(string $key): bool;

    public function missing(string $key): bool;

    public function get(string $key, string $default = null): string;

    public function all(): array;
}