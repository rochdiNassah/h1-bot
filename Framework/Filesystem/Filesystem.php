<?php declare(strict_types=1);

namespace Automation\Framework\Filesystem;

use Automation\Framework\Application;

class Filesystem implements FilesystemInterface
{
    private string $old_root;

    public function __construct(
        private string $root,
        private Application $app
    ) {
        $this->old_root = $root;
    }

    public function __toString(): string
    {
        return $this->root;
    }

    public function exists(string|array $path): bool
    {
        $paths = is_array($path) ? $path : func_get_args();

        foreach ($paths as $path) {
            if (!in_array($path[0], ['/', '\\'])) {
                $path = str_replace('\\/', DIRECTORY_SEPARATOR, sprintf('%s/%s', $this->root, $path));
            }

            if (!file_exists($path)) {
                return false;
            }
        }

        return true;
    }

    public function missing(string|array $path): bool
    {
        return !$this->exists($path);
    }

    public function to(string $path): string
    {
        $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, sprintf('%s/%s', $this->root, $path));

        return $path;
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
        rename($this->to($path), $this->to($new_name));

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
        if (!in_array($path[0], ['\\', '/'])) {
            $this->root = $this->root.DIRECTORY_SEPARATOR.$path;

            return;
        }

        $this->root = $path;
    }

    public function reset_root(): void
    {
        $this->root = $this->old_root;
    }

    public function old_root(): string
    {
        return $this->old_root;
    }
}