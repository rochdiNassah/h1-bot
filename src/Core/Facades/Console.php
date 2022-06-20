<?php declare(strict_types=1);

namespace Automation\Core\Facades;

class Console extends Facade
{
    protected static function accessor(): string
    {
        return app()->coreAliases('console');
    }
}