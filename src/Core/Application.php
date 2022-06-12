<?php declare(strict_types=1);

namespace Automation\Core;

use stdClass, Closure, Exception, ReflectionClass, ReflectionFunction, ReflectionMethod, ReflectionObject, ReflectionUnionType;
use Dotenv\Dotenv;
use Automation\Exceptions\{ClassNotFoundException, DependencyNotFoundException};

final class Application
{
    private static $instance;

    private array $instances = [];

    private array $shared = [];

    private function __construct(

    ) {
        $this->shared[__CLASS__] = $this;
    }

    private function __clone() {}

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

        $this->instantiateCoreClasses();
    }

    public function coreAliases(): array
    {
        return [
            'filesystem' => \Automation\Core\Filesystem::class
        ];
    }

    private function instantiateCoreClasses(): void
    {
        $core_aliases = $this->coreAliases();

        $this->resolve($core_aliases['filesystem'], ['project_root' => PROJECT_ROOT], share: true);
    }

    public function __get(string $alias): mixed
    {
        $aliases = $this->coreAliases();

        if (array_key_exists($alias,$aliases )) {
            return $this->shared[$aliases[$alias]];
        }

        throw new Exception(sprintf('"%s" is not a core alias.', $alias));
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
        if ($abstract instanceof Closure) {
            $reflector = new ReflectionFunction($abstract);

            $parameters = $reflector?->getParameters();
        }

        $dependencies = array_merge($params, $this->resolveDependencies($parameters ?? []));

        $resolved = is_callable($abstract) ? call_user_func($abstract, ...$dependencies) : new $abstract(...$dependencies);

        if (is_string($abstract)) {
            $this->instances[] = $resolved;

            if ($share) $this->shared[$abstract] = $resolved;
        }

        return $resolved;
    }

    private function resolveDependencies(array $params): array
    {
        $results = [];

        foreach ($params as $param):
            if ($param->hasType()) {
                $param_name = $param->getName();
                $param_type = $param->getType();

                if ($param_type instanceof ReflectionUnionType):
                    $types = $param_type->getTypes();

                    foreach ($types as $type) {
                        if (!$type->isBuiltIn()) {
                            $type_name = $type->getName();

                            $results[$param_name] = $this->makeDependency($type_name);

                            continue 2;
                        }
                    }
                endif;

                if ($param_type instanceof \ReflectionNamedType) {
                    if (!$param_type->isBuiltIn()) {
                        $type_name = $param_type->getName();

                        $results[$param_name] = $this->makeDependency($type_name);
                    }
                }
            }
        endforeach;

        return $results;
    }

    private function makeDependency(string $type_name): mixed
    {
        if (!class_exists($type_name)) {
            throw new DependencyNotFoundException($type_name);
        }

        return $this->resolve($type_name);
    }
}