<?php declare(strict_types=1);

namespace Automation\Core\Routing;

use Automation\Core\Application;

class Route
{
    private string $pattern;

    private array $param_names;

    private array $param_values;

    private array $params;

    public function __construct(
        private string $method,
        private string $path,
        private mixed $action,
        private Application $app
    ) {

    }

    public function parse(): void
    {
        $this->path = trim($this->path, '\\/');

        $wild_cards = preg_match_all('/\{(.*?)\}/', $this->path, $match);

        if ($match) {
            
        }
    }

    public function path(): string
    {
        return $this->path;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function action(): array|callable
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

    public function params(): array
    {
        return $this->params;
    }
}