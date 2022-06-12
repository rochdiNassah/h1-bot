<?php declare(strict_types=1);

namespace Automation\Core\Facades;

class Filesystem extends Facade
{
    protected static function accessor(): string
    {
        return \Automation\Core\Filesystem::class;
    }
}