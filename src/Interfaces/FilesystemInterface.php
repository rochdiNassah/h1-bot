<?php declare(strict_types=1);

namespace Automation\Interfaces;

interface FilesystemInterface
{
    public function exists(string $path = ''): bool;

    public function missing(string $path = ''): bool;

    public function to(string $path): self;

    public function remove(string $path, bool|int $recursive = false): bool;

    public function rename(string $path): bool;
}