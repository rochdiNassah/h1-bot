<?php declare(strict_types=1);

namespace Automation\Framework\Facades;

class Session extends Facade
{
    protected static function accessor(): string
    {
        return app()->serviceAliases('session');
    }
}