<?php declare(strict_types=1);

namespace Automation\Framework\Routing;

use Automation\Framework\Application;
use Automation\Framework\Facades\View;

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

    private function register(string $method, string $path, array|callable|string $action): void
    {
        $route = $this->app->resolve(Route::class, [$method, $path, $action]);

        $this->routes[hash('sha512', $method.$path)] = $route;

        $route->parse();
    }

    public function view(string $path, string $view): void
    {
        $this->register('GET', $path, function () use ($view) {
            return View::make($view);
        });
    }

    public function currentRoute(): Route
    {
        return $this->current_route;
    }

    public function run(): void
    {
        $request = $this->app->request;

        foreach ($this->routes as $route) {
            preg_match($route->pattern(), $request->path(), $match);

            if (isset($match[0]) && array_shift($match) === $request->path() && $route->method() === $request->method()) {
                $this->current_route = $route;

                $params = array_combine($route->paramNames(), $match);

                $route->setParameters($params);

                $route->run();

                return;
            }
        }

        throw app(NotFoundHttpException::class, ['path' => $request->path()]);
    }
}