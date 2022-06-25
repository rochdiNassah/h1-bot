<?php declare(strict_types=1);

namespace Automation\Framework\Facades;

class View extends Facade
{
    protected static function accessor(): string
    {
        return app()->serviceAliases('view');
    }
}