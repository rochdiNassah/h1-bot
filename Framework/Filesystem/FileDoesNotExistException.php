<?php declare(strict_types=1);

namespace Automation\Framework\Filesystem;

class FileDoesNotExistException extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct(sprintf('"%s" file does not exist.', $path));
    }
}