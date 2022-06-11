<?php declare(strict_types=1);

namespace Automation;

use stdClass, Closure, Exception, ReflectionClass, ReflectionFunction, ReflectionMethod, ReflectionObject;
use Dotenv\Dotenv;

final class Application
{
    private static $instance;

    public static function instance(bool|int $recreate = false): self
    {
        $i = static::$instance;

        if (is_null($i) || $recreate) {
            $i = static::$instance = new self();
        }

        return $i;
    }

    public function run(): void
    {
        set_error_handler('error_handler');
        set_exception_handler('exception_handler');

        Dotenv::createImmutable(PROJECT_ROOT)->load();
    }
}