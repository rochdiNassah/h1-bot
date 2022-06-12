<?php declare(strict_types=1);

namespace Automation\Core\Facades;

class Request extends Facade
{
    protected static function accessor(): string
    {
        return \Automation\Core\Http\Request::class;
    }
}