<?php declare(strict_types=1);

namespace Automation\Framework\Http;

use Automation\Framework\Application;

class Request
{
    private array $headers;

    private string $uri;

    private string $base_uri;

    private string $path;

    private string $base_path;

    private string $method;

    private array $inputs;

    public function __construct(
        private Application $app,
        private Server $server
    ) {

    }

    public function parse(): void
    {
        foreach ($this->server->all() as $key => $value):
            $header_prefix = 'HTTP_';

            if (str_starts_with($key, $header_prefix)):
                $this->headers[substr($key, strlen($header_prefix))] = $value;
            endif;
        endforeach;

        $script_name    = $this->server->get('SCRIPT_NAME');
        $request_uri    = trim($this->server->get('REQUEST_URI'), '\\/');
        $request_scheme = $this->server->get('REQUEST_SCHEME');
        $server_name    = $this->server->get('SERVER_NAME');

        $this->base_path = substr($script_name, 0, -strlen(basename($script_name)));
        $this->base_uri  = sprintf('%s://%s%s', $request_scheme, $server_name, $this->base_path);
        $this->uri       = sprintf('%s/%s', $this->base_uri, $request_uri);
        $this->path      = parse_url(substr($this->uri, strlen($this->base_path) + strlen($this->base_uri)), PHP_URL_PATH);

        $this->method    = $this->server->get('REQUEST_METHOD');

        $this->inputs    = array_merge($_REQUEST, $_FILES);
    }

    public function simulate(string $method, string $path, array $headers = [], array $inputs = []): void
    {
        $this->method  = strtoupper($method);
        $this->path    = trim($path, '\\/');
        $this->headers = $headers;
        $this->inputs  = $inputs;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function getHeader(string $key): string
    {
        return $this->headers[strtoupper($key)] ?? '';
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function base_uri(): string
    {
        return $this->base_uri;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function inputs(): array
    {
        return $this->inputs;
    }

    public function input(string $name): string|array|null
    {
        return $this->inputs[$name] ?? null;
    }

    public function missing(string $key): bool
    {
        return !array_key_exists($key, $this->inputs);
    }

    public function flash(): self
    {
        foreach ($this->inputs as $key => $value) {
            app('session')->set($key, $value);

            app('response')->registerAfterResponseHook(function (Session $session) use ($key) {
                $session->forget($key);
            });
        }

        return $this;
    }

    public function flashExcept($except): self
    {
        $except = is_array($except) ? $except : func_get_args();

        $inputs = array_map(function ($key) {
            if (isset($this->inputs[$key])) {
                $value = $this->inputs[$key];

                unset($this->inputs[$key]);
    
                return [$key => $value];
            }

            return [];
        }, $except);

        $this->flash();

        $this->inputs = array_merge($this->inputs, reset($inputs));

        return $this;
    }

    public function old(string $key): string|null
    {
        return app('session')->pull($key);
    }
}