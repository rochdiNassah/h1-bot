<?php declare(strict_types=1);

namespace Automation\Core;

use stdClass, Closure, Exception, ReflectionClass, ReflectionFunction, ReflectionMethod, ReflectionObject, ReflectionUnionType, ReflectionNamedType, ReflectionParameter;
use Dotenv\Dotenv;
use Automation\Exceptions\{ClassNotFoundException, DependencyNotFoundException};

final class Application
{
    private static $instance;

    private array $instances = [];

    private array $shared = [];

    private array $bindings = [];

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

        $this->bind('project_root', dirname(__DIR__, 2));

        Dotenv::createImmutable($this->resolve('project_root'))->load();

        $in_cli_mode = php_sapi_name() === 'cli';

        $this->instantiateCoreClasses($in_cli_mode);

        if ($in_cli_mode) {
            return;
        }

        $this->request->parse();
    }

    public function coreAliases(): array
    {
        return [
            'filesystem' => \Automation\Core\Filesystem::class,
            'request'    => \Automation\Core\Http\Request::class,
            'database'   => \Automation\Core\Database::class,
            'router'     => \Automation\Core\Router::class,
            'cookie'     => \Automation\Core\Http\Cookie::class,
            'session'    => \Automation\Core\Http\Session::class,
            'view'       => \Automation\Core\View::class,
            'console'    => \Symfony\Component\Console\Application::class,
            'encoder'    => \Automation\Core\Encoder::class,
        ];
    }

    private function consoleCommands(): array
    {
        return [
            \Automation\App\Commands\Encoding\EncodeCommand::class,
            \Automation\App\Commands\Encoding\DecodeCommand::class,
            \Automation\App\Commands\Encoding\DetectEncodingCommand::class,
            \Automation\App\Commands\Encoding\SplitJWTCommand::class,
        ];
    }

    private function instantiateCoreClasses($running_in_cli_mode = false): void
    {
        $core_aliases = $this->coreAliases();

        $this->resolve($core_aliases['filesystem'], ['project_root' => app('project_root')], share: true);
        $this->resolve($core_aliases['encoder'], share: true);

        if ($running_in_cli_mode) {
            $this->resolve($core_aliases['console'], share: true);

            $console_commands = $this->consoleCommands();

            foreach ($console_commands as $command) {
                $this->console->add($this->resolve($command));
            }

            return;
        }

        $this->resolve($core_aliases['request'], share: true);
        $this->resolve($core_aliases['router'], share: true);
    }

    public function __get(string $alias): mixed
    {
        $aliases = $this->coreAliases();

        if (array_key_exists($alias, $aliases)) {
            return $this->shared[$aliases[$alias]];
        }

        throw new Exception(sprintf('"%s" is not a core alias.', $alias));
    }

    public function bind(string $abstract, mixed $concrete): void
    {
        $this->bindings[$abstract] = $concrete;
    }

    public function resolve(string|object|array|callable $abstract, array $params = [], bool|int $share = false): mixed
    {
        if (is_string($abstract)) {
            if (array_key_exists($abstract, $this->shared)) {
                return $this->shared[$abstract];
            }
            if (array_key_exists($abstract, $this->bindings)) {
                $abstract = $this->bindings[$abstract];

                if (is_string($abstract)) {
                    return $abstract;
                } else {
                    return $this->resolve($abstract);
                }
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
            if ($param instanceof ReflectionParameter) {
                if ($param->hasType()) {
                    $param_name = $param->getName();
                    $param_type = $param->getType();
    
                    if ($param_type instanceof ReflectionNamedType) {
                        if (!$param_type->isBuiltIn()) {
                            $type_name = $param_type->getName();
    
                            if (!class_exists($type_name)) {
                                throw new DependencyNotFoundException($type_name);
                            }
    
                            $results[$param_name] = $this->resolve($type_name);
    
                            continue;
                        }
                    }
                }
            }
        endforeach;

        return $results;
    }
}
