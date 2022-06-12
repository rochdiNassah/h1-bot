<?php declare(strict_types=1);

namespace Automation\Core;

use Automation\Interfaces\FilesystemInterface;
use Automation\Core\Application;

class Filesystem implements FilesystemInterface
{
    private string $current_path;

    public function __construct(
        private Application $app,
        private string $project_root
    ) {
        $this->current_path = $project_root;
    }

    public function __toString(): string
    {
        return $this->current_path;
    }

    public function exists(string $path = null): bool
    {
        return file_exists((string) $this.$path);
    }

    public function missing(string $path = null): bool
    {
        return !$this->exists();
    }

    public function remove(string $path, bool|int $recursive = false): bool
    {
        return true;
    }

    public function to(string $path): self
    {
        $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, sprintf('%s/%s', $this->project_root, $path));

        $this->current_path = $path;

        return $this;
    }

    public function rename(string $path): bool
    {
        return true;
    }
}