<?php declare(strict_types=1);

namespace Automation\Core\Filesystem;

class PathIsNotReadableException extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('"%s" path is not readable.', $path));
    }
}