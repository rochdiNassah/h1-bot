<?php declare(strict_types=1);

namespace Automation\Framework\Facades;

class Client extends Facade
{
    protected static function accessor(): string
    {
        return __CLASS__;
    }
}