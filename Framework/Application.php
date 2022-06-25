<?php declare(strict_types=1);

namespace Automation\Framework;

use stdClass, Closure, Exception, ReflectionClass, ReflectionFunction, ReflectionMethod, ReflectionObject, ReflectionUnionType, ReflectionNamedType, ReflectionParameter;
use Dotenv\Dotenv;
use Automation\Exceptions\Framework\{ClassNotFoundHttpException, DependencyNotFoundHttpException};

final class Application
{
    private static $instance;

    private array $instances = [];

    private array $shared = [];

    private array $bindings = [];

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

        $this->bind('project_root', dirname(__DIR__, 1));

        Dotenv::createImmutable($this->resolve('project_root'))->load();
        
        $in_cli_mode = php_sapi_name() === 'cli';
        
        $this->instantiateServices($in_cli_mode);

        if ($in_cli_mode) {
            return;
        }

        require $this->filesystem->to('routes.php');
        
        $this->session->start();

        $this->request->parse();

        $this->router->run();

        $this->response->send();

        $this->response->runAfterResponseHooks();
    }

    public function __get(string $alias): mixed
    {
        $aliases = $this->serviceAliases();

        if (array_key_exists($alias, $aliases)) {
            return $this->shared[$aliases[$alias]];
        }

        throw new Exception(sprintf('"%s" is not a service.', $alias));
    }

    public function serviceAliases(string $key = null): array|string
    {
        $aliases = [
            'filesystem'  => \Automation\Framework\Filesystem\Filesystem::class,
            'request'     => \Automation\Framework\Http\Request::class,
            'response'    => \Automation\Framework\Http\Response::class,
            'database'    => \Automation\Framework\Database\Database::class,
            'router'      => \Automation\Framework\Routing\Router::class,
            'cookie'      => \Automation\Framework\Http\Cookie::class,
            'session'     => \Automation\Framework\Http\Session::class,
            'view'        => \Automation\Framework\View\ViewFactory::class,
            'encoder'     => \Automation\Framework\Encoding\Encoder::class,
            'application' => \Automation\Framework\Application::class,
        ];
        
        if (!is_null($key)) {
            return $aliases[$key];
        }

        return $aliases;
    }

    private function instantiateServices($running_in_cli_mode = false): void
    {
        $aliases = $this->serviceAliases();

        $this->share($aliases['filesystem'], ['root' => app('project_root')]);
        $this->share($aliases['encoder']);

        if ($running_in_cli_mode) {
            return;
        }

        $this->share($aliases['session']);
        $this->share($aliases['request']);
        $this->share($aliases['response']);
        $this->share($aliases['router']);
    }

    public function bind(string $abstract, mixed $concrete): void
    {
        if (array_key_exists($abstract, $this->bindings)) {
            throw new Exception(sprintf('"%s" is already bound!', $abstract));
        }

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
            if (array_key_exists($abstract, $this->serviceAliases())) {
                return $this->{$abstract};
            }
            if (!class_exists($abstract)) {
                throw new ClassNotFoundHttpException($abstract);
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

    public function share(object|string $class, array $params = []): void
    {
        if (is_string($class)) {
            $abstract = $class;
            $concrete = $this->resolve($abstract, $params, share: true);
        }
        if (is_object($class)) {
            $abstract = get_class($class);
            $concrete = $class;
        }

        $this->shared[$abstract] = $concrete;
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
                                throw new DependencyNotFoundHttpException($abstract, $type_name);
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

    private function __construct(

    ) {
        $this->shared[__CLASS__] = $this;
    }
    
    private function __clone() {}
}
