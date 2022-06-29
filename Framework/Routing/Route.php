<?php declare(strict_types=1);

namespace Automation\Framework\Routing;

use Automation\Framework\Application;
use Automation\Framework\Exceptions\ControllerNotFoundException;

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

        return (string) $result;
    }

    public function parse(): void
    {
        $this->path = trim($this->path, '\\/');

        preg_match_all('/\{(.*?)\}/', $this->path, $param_names);

        $pattern = sprintf('/%s/', str_replace(['\\', '/'], ['\\\\', '\/'], $this->path));

        if ($param_names) {
            $this->param_names = $param_names[1];

            $pattern = str_replace($param_names[0], '(\/\/|[^\/?].*){1,}', $pattern);
        }

        $this->pattern = $pattern;
    }

    public function run(): void
    {
        if (is_array($this->action) || is_string($this->action)) {
            $controller = is_string($this->action) ? $this->action : $this->action[0];

            if (is_array($this->action)) {
                $this->action[0] = app($controller);
            } else {
                $this->action = app($controller);
            }

            if (!class_exists($controller)) {
                throw new ControllerNotFoundException($controller);
            }
        }

        $this->result = $this->app->resolve($this->action, $this->parameters);

        $this->app->share($this);
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

    public function result(): mixed
    {
        return $this->result;
    }
}