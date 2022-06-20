<?php declare(strict_types=1);

namespace Automation\Exceptions;

use Closure;

class DependencyNotFoundException extends Exception
{
    public function __construct($abstract, string $dependency)
    {
        parent::__construct(sprintf(
            '"%s" dependency not found when trying to resolve %s.',
            $dependency,
            is_string($abstract) ? $abstract : ($abstract instanceof Closure ? 'a closure' : 'an abstract')
        ));
    }
}
