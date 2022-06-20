<?php declare(strict_types=1);

namespace Automation\Exceptions;

class DependencyNotFoundException extends ClassNotFoundException
{
    public function __construct($abstract, string $dependency)
    {
        parent::__construct($dependency);
    }
}
