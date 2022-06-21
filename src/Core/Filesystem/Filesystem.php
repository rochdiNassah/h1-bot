<?php declare(strict_types=1);

namespace Automation\Core\Filesystem;

use Automation\Core\Application;

class Filesystem implements FilesystemInterface
{
    private string $current_path;

    public function __construct(
        private string $root,
        private Application $app
    ) {
        $this->current_path = $root;
    }

    public function __toString(): string
    {
        $current_path = $this->current_path;

        $this->current_path = $this->root;

        return $current_path;
    }

    public function exists(string|array $path = ''): bool
    {
        $root = (string) $this;

        $paths = is_array($path) ? $path : [$path];

        foreach ($paths as $path) {
            $path = rtrim($root.DIRECTORY_SEPARATOR.$path, '\\/');

            if (!file_exists($path)) {
                return false;
            }
        }

        return true;
    }

    public function missing(string|array $path = ''): bool
    {
        return !$this->exists($path);
    }

    public function to(string $path): self
    {
        $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, sprintf('%s/%s', $this->current_path, $path));

        $this->current_path = $path;

        return $this;
    }

    public function remove(string $path): bool
    {
        return true;
    }

    public function rename(string $path, string $new_name): bool
    {
        return true;
    }

    public function replace_in_file(string|array $search, string|array $replace, string $path, bool|int $save): string|bool
    {
        return true;
    }

    public function update_root(string $path): void
    {
        $this->root = $path;
        $this->current_path = $path;
    }
}