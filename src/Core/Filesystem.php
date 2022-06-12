<?php declare(strict_types=1);

namespace Automation\Core;

use Automation\Interfaces\FilesystemInterface;

class Filesystem implements FilesystemInterface
{
    public function exists(string $path): bool
    {
        return true;
    }

    public function missing(string $path): bool
    {
        return !$this->exists();
    }

    public function remove(string $path, bool|int $recursive = false): bool
    {
        return true;
    }

    public function to(string $path): string
    {
        return '';
    }

    public function rename(string $path): bool
    {
        return true;
    }
}