<?php declare(strict_types=1);

namespace Automation\Core\Http;

use Automation\Core\Application;
use Automation\Interfaces\RequestInterface;
use Automation\Core\Http\Bags\ServerBag;

class Request implements RequestInterface
{
    private array $headers;

    private string $uri;

    private string $base_uri;

    private string $path;

    private string $base_path;

    private string $method;

    public function __construct(
        private Application $app,
        private ServerBag $server
    ) {

    }

    public function parse(): void
    {
        foreach ($this->server->all() as $key => $value):
            if (str_starts_with($key, 'HTTP_')):
                $this->headers[$key] = $value;
            endif;
        endforeach;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function path(): string
    {
        return $this->path;
    }
}