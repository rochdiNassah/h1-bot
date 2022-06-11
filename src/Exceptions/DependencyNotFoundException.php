<?php declare(strict_types=1);

namespace Automation\Exceptions;

class DependencyNotFoundException extends ClassNotFoundException
{
    public function __construct(string $dependeny)
    {
        parent::__construct($dependeny);
    }
}