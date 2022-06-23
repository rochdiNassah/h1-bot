<?php declare(strict_types=1);

namespace Automation\Core\Filesystem;

interface FilesystemInterface
{
    /**
     * Determines if the given path(s) is exists.
     * 
     * @param  string|array  $path
     * @return bool
     */
    public function exists(string|array $path = ''): bool;

    /**
     * Determines if the given path(s) is missing.
     * 
     * @param  string|array  $path
     * @return bool
     */
    public function missing(string|array $path = ''): bool;

    /**
     * Generates a path to the given path.
     * 
     * This method saves the generated path in the $current_path property.
     * 
     * @param  string  $path
     * @return self
     */
    public function to(string $path): self;

    /**
     * Removes the given path(s).
     * 
     * @param  string  $paths
     * @return bool
     */
    public function remove(string|array $paths): bool;

    /**
     * Renames the given path.
     * 
     * @param  string  $path
     * @param  string  $new_name
     * @return bool
     */
    public function rename(string $path, string $new_name): bool;

    /**
     * Search and replace from inside a file.
     * 
     * @param  string|array  $search
     * @param  string|array  $replace
     * @param  string  $path
     * @param  bool|int  $save
     * @return bool|string
     */
    public function replace_in_file(string|array $search, string|array $replace, string $path, bool|int $save = true): bool|string;

    /**
     * Updates the $root path to the given one.
     * 
     * @param  string  $path
     * @return void
     */
    public function update_root(string $path): void;

    /**
     * Resets the root to the old one.
     * 
     * @return void
     */
    public function reset_root(): void;

    /**
     * Get the old root.
     * 
     * @return string
     */
    public function old_root(): string;

    /**
     * Get the current path.
     * 
     * @return string
     */
    public function current_path(): string;
}
