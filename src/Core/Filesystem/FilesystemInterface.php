<?php declare(strict_types=1);

namespace Automation\Core\Filesystem;

interface FilesystemInterface
{
    public function exists(string|array $path = ''): bool;

    public function missing(string|array $path = ''): bool;

    public function to(string $path): self;

    public function remove(string $path, bool|int $recursive = false): bool;

    public function rename(string $path): bool;
}