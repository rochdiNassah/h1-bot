<?php declare(strict_types=1);

namespace Automation\Framework\Filesystem;

class PathIsNotWritableException extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('"%s" path is not writable.', $path));
    }
}