<?php declare(strict_types=1);

namespace Automation\Framework\Http;

use Automation\Framework\Application;
use Automation\Framework\Facades\Validator;

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
        $request_scheme = $this->server->get('REQUEST_SCHEME') ?? 'http';
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

    public function getHeader(string $key): string|null
    {
        return $this->headers[strtoupper($key)] ?? null;
    }

    public function getReferer(): string
    {
        return $this->getHeader('referer');
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

    public function validate(): void
    {
        $errors = Validator::getErrors();

        if (!empty($errors)) {
            $this->flash();
            
            $session = app('session');

            $flash = unserialize($session->get('flash') ?? 'a:0:{}');

            $flash['errors'] = $errors;

            $flash = serialize($flash);

            $session->set('flash', $flash);

            $this->app->response->setStatusCode(301)->redirect($this->getReferer());
        }
    }

    public function input(string $name): string|array|null|object
    {
        return Validator::make($name, $this->inputs[$name]);
    }

    public function missing(string $key): bool
    {
        return !array_key_exists($key, $this->inputs);
    }

    public function flash(): self
    {
        foreach ($this->inputs as $key => $value) {
            if (is_string($value)) {
                $session = app('session');

                $flash = unserialize($session->get('flash') ?? 'a:0:{}');

                $flash['old'][$key] = $value;

                $flash = serialize($flash);

                $session->set('flash', $flash);
            }
        }

        return $this;
    }

    public function getFlash(): array
    {
        return unserialize(app('session')->get('flash') ?? 'a:0:{}');
    }

    public function old(string $key): string|null
    {
        return $this->getFlash()['old'][$key] ?? null;
    }

    public function errors(): array | null
    {
        return $this->getFlash()['errors'] ?? null;
    }
}