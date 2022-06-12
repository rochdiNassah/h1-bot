<?php declare(strict_types=1);

namespace Automation\Core\Facades;

abstract class Facade
{
    public static function __callStatic(string $method, array $params = []): mixed
    {
        $accessor = static::accessor();

        return app($accessor)->{$method}(...$params);
    }
}