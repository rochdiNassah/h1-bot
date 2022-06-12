<?php declare(strict_types=1);

namespace Automation\Core;

use Automation\Interfaces\FilesystemInterface;
use Automation\Core\Application;

class Filesystem implements FilesystemInterface
{
    private string $current_path;

    public function __construct(
        private string $project_root,
        private Application $app
    ) {
        $this->current_path = $project_root;
    }

    public function __toString(): string
    {
        $current_path = $this->current_path;

        $this->current_path = $this->project_root;

        return $current_path;
    }

    public function exists(string $path = ''): bool
    {
        $path = $this->to($path);

        return file_exists((string) $path);
    }

    public function missing(string $path = null): bool
    {
        return !$this->exists($path);
    }

    public function remove(string $path, bool|int $recursive = false): bool
    {
        return true;
    }

    public function to(string $path): self
    {
        $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, sprintf('%s/%s', $this->current_path, $path));

        $this->current_path = $path;

        return $this;
    }

    public function rename(string $path): bool
    {
        return true;
    }
}