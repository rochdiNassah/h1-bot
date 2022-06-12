<?php declare(strict_types=1);

namespace Automation\Core;

use Automation\Interfaces\FilesystemInterface;
use Automation\Core\Application;

class Filesystem implements FilesystemInterface
{
    public function __construct(
        private Application $app,
        private string $project_root
    ) {

    }

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