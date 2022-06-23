<?php declare(strict_types=1);

namespace Automation\Core\Routing;

use Automation\Core\Application;

class Route
{
    private string $pattern;

    private array $param_names;

    private array $param_values;

    private array $parameters;

    public function __construct(
        private string $method,
        private string $path,
        private mixed $action,
        private Application $app
    ) {

    }

    public function __toString(): string
    {
        $result = $this->result;

        if (is_array($result)) {
            $result = json_encode($result);
        }

        return $result;
    }

    public function parse(): void
    {
        $this->path = trim($this->path, '\\/');

        preg_match_all('/\{(.*?)\}/', $this->path, $param_names);

        $pattern = sprintf('/%s/', str_replace(['\\', '/'], ['\\\\', '\/'], $this->path));

        if ($param_names) {
            $this->param_names = $param_names[1];

            $pattern = str_replace($param_names[0], '(\/\/|[^\/?]*)', $pattern);
        }

        $this->pattern = $pattern;
    }

    public function run(): void
    {
        if (is_array($this->action)) {
            $this->action[0] = $this->app->resolve($this->action[0]);
        }

        $this->result = $this->app->resolve($this->action, $this->parameters);

        $this->app->share(Route::class, $this);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function action(): mixed
    {
        return $this->action;
    }

    public function pattern(): string
    {
        return $this->pattern;
    }

    public function paramNames(): array
    {
        return $this->param_names;
    }

    public function paramValues(): array
    {
        return $this->param_values;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $params): void
    {
        $this->parameters = $params;
    }

    public function setResult(mixed $result): void
    {
        $this->result = $result;
    }
}