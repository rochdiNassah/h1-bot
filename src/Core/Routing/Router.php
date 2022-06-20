<?php declare(strict_types=1);

namespace Automation\Core\Routing;

use Automation\Core\Application;

class Router
{
    private const SUPPORTED_HTTP_METHODS = [
        'GET', 'POST', 'OPTIONS', 'DELETE', 'PUT', 'TRACE', 'CONNECT', 'PATCH', 'HEAD'
    ];

    private array $routes;

    private Route $current_route;

    public function __construct(
        private Application $app
    ) {
        
    }

    public function __call(string $method, array $params): void
    {
        $method = strtoupper($method);

        if (!in_array($method, self::SUPPORTED_HTTP_METHODS)) {
            throw new UnsupportedHttpMethodException($method);
        }

        list($path, $action) = $params;

        $this->register($method, $path, $action);
    }

    private function register(string $method, string $path, array|callable $action): void
    {
        $route = $this->app->resolve(Route::class, [$method, $path, $action]);

        $this->routes[] = $route;

        $route->parse();
    }

    public function currentRoute(): Route
    {
        return $this->current_route;
    }
}