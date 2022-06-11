<?php declare(strict_types=1);

namespace Automation\Core;

use stdClass, Closure, Exception, ReflectionClass, ReflectionFunction, ReflectionMethod, ReflectionObject;
use Dotenv\Dotenv;
use Automation\Exceptions\ClassNotFoundException;

final class Application
{
    private static $instance;

    private array $instances = [];

    private array $shared = [];

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

    public function resolve(string|object|array|callable $abstract, array $params = [], bool|int $share = false): mixed
    {
        if (is_string($abstract)) {
            if (array_key_exists($abstract, $this->shared)) {
                return $this->shared[$abstract];
            }
            if (!class_exists($abstract)) {
                throw new ClassNotFoundException($abstract);
            }

            $reflector = new ReflectionClass($abstract);
            
            $parameters = $reflector?->getConstructor()?->getParameters();
        }
    }

    private function resolveDependencies(array $params): array
    {
        $results = [];

        return $results;
    }
}