<?php declare(strict_types=1);

namespace Automation\Exceptions;

class ClassNotFoundException extends Exception
{
    public function __construct(string $class)
    {
        $message = sprintf('"%s" class not found.', $class);

        parent::__construct($message);
    }
}