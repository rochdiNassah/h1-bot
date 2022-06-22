<?php declare(strict_types=1);

namespace Automation\Core\Filesystem;

use Automation\Core\Application;

class Filesystem implements FilesystemInterface
{
    private string $old_root;

    private string $previous_root;

    private string $new_root;

    private string $current_path;

    public function __construct(
        private string $root,
        private Application $app
    ) {
        $this->old_root      = $root;
        $this->previous_root = $root;
        $this->current_path  = $root;
        $this->new_root      = $root;
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

        $paths = is_array($path) ? $path : func_get_args();

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

    public function remove(string|array $paths): bool
    {
        $paths = is_array($paths) ? $paths : func_get_args();

        foreach ($paths as $path):
            $path = (string) $this->to($path);

            if (is_dir($path)):
                @rmdir($path);
            else:
                @unlink($path);
            endif;
        endforeach;

        return true;
    }

    public function rename(string $path, string $new_name): bool
    {
        rename((string) $this->to($path), (string) $this->to($new_name));

        return true;
    }

    public function replace_in_file(string|array $search, string|array $replace, string $path, bool|int $save = true): bool|string
    {
        if ($this->to($path)->missing()) {
            throw new FileDoesNotExistException($path);
        }

        $path = (string) $this->to($path);

        if (!is_writable($path)) {
            throw new PathIsNotWritableException($path);
        }
        if (!is_readable($path)) {
            throw new PathIsNotReadableException($path);
        }
        
        $contents = str_replace($search, $replace, file_get_contents($path));

        if (!$save) {
            return $contents;
        }

        file_put_contents($path, $contents);

        return true;
    }

    public function update_root(string $path): void
    {
        $this->previous_root = $this->new_root;

        $this->root = $path;
        $this->current_path = $path;
        $this->new_root = $path;
    }

    public function reset_root(): void
    {
        $this->previous_root = $this->root;
        $this->new_root      = $this->old_root;
        $this->current_path  = $this->old_root;
        $this->root          = $this->old_root;
    }

    public function new_root(): string
    {
        return $this->new_root;
    }

    public function previous_root(): string
    {
        return $this->previous_root;
    }

    public function old_root(): string
    {
        return $this->old_root;
    }

    public function current_path(): string
    {
        return $this->current_path;
    }
}