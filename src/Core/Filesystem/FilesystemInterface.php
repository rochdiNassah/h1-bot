<?php declare(strict_types=1);

namespace Automation\Core\Filesystem;

interface FilesystemInterface
{
    /**
     * Determines if the given path is exists.
     * 
     * @param  string|array  $path
     * @return bool
     */
    public function exists(string|array $path = ''): bool;

    /**
     * Determines if the given path is missing.
     * 
     * @param  string|array  $path
     * @return bool
     */
    public function missing(string|array $path = ''): bool;

    /**
     * Generates a path to the given path.
     * 
     * @param  string  $path
     * @return self
     */
    public function to(string $path): self;

    /**
     * Removes the given path.
     * 
     * @param  string  $path
     * @return bool
     */
    public function remove(string $path): bool;

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
     * This method return the new contents on success and false on failure.
     * If $save param evaluates to true, it saves the file with the new contents and returns true on success.
     * 
     * @param  string|array  $search
     * @param  string|array  $replace
     * @param  string  $path
     * @param  bool|int  $save If evaluates to true, save the file with the new contents.
     * @return string|bool
     */
    public function replace_in_file(string|array $search, string|array $replace, string $path, bool|int $save): string|bool;
}