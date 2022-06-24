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

        require $this->filesystem->to('routes.php');
        
        $this->session->start();
        $this->request->parse();
        $this->router->run();
        $this->response->send();
    }

    public function coreAliases(string $key = null): array|string
    {
        $aliases = [
            'filesystem'  => \Automation\Core\Filesystem\Filesystem::class,
            'request'     => \Automation\Core\Http\Request::class,
            'response'    => \Automation\Core\Http\Response::class,
            'database'    => \Automation\Core\Database\Database::class,
            'router'      => \Automation\Core\Routing\Router::class,
            'cookie'      => \Automation\Core\Http\Cookie::class,
            'session'     => \Automation\Core\Http\Session::class,
            'view'        => \Automation\Core\View\ViewFactory::class,
            'encoder'     => \Automation\Core\Encoding\Encoder::class,
            'application' => \Automation\Core\Application::class,
        ];
        
        if (!is_null($key)) {
            return $aliases[$key];
        }

        return $aliases;
    }

    private function instantiateCoreClasses($running_in_cli_mode = false): void
    {
        $core_aliases = $this->coreAliases();

        $this->resolve($core_aliases['filesystem'], ['root' => app('project_root')], share: true);
        $this->resolve($core_aliases['encoder'], share: true);

        if ($running_in_cli_mode) {
            return;
        }

        $this->resolve($core_aliases['session'], share: true);
        $this->resolve($core_aliases['request'], share: true);
        $this->resolve($core_aliases['response'], share: true);
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
                } else if (is_object($abstract)) {
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

        $dependencies = array_merge($params, $this->resolveDependencies($abstract, $parameters ?? []));

        $resolved = is_callable($abstract) || is_array($abstract) ? call_user_func($abstract, ...$dependencies) : new $abstract(...$dependencies);

        if (is_string($abstract)) {
            $this->instances[] = $resolved;

            if ($share) $this->shared[$abstract] = $resolved;
        }

        return $resolved;
    }

    private function resolveDependencies($abstract, array $params): array
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
                                throw new DependencyNotFoundException($abstract, $type_name);
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

    public function share(string $abstract, object $concrete): void
    {
        $this->shared[$abstract] = $concrete;
    }
}
