<?php declare(strict_types=1);

namespace Automation\Framework\Http;

use Automation\Framework\Application;
use Automation\Framework\Http\Bags\ServerBag;

class Request
{
    private array $headers;

    private string $uri;

    private string $base_uri;

    private string $path;

    private string $base_path;

    private string $method;

    private array $inputs;

    private array $errors = [];

    public function __construct(
        private Application $app,
        private ServerBag $server
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

        $this->inputs    = $_REQUEST;
    }

    public function simulate(string $method, string $path, array $headers = []): void
    {
        $this->method  = strtoupper($method);
        $this->path    = trim($path, '\\/');
        $this->headers = $headers;
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

    public function input(string $name): string
    {
        return $this->inputs[$name];
    }

    public function flash(): void
    {
        foreach ($this->inputs as $key => $value) {
            app('session')->set($key, $value);

            app('response')->registerAfterResponseHook(function (Session $session) use ($key) {
                $session->forget($key);
            });
        }
    }

    public function flashExcept($except): void
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
    }

    public function old(string $key): string|null
    {
        return app('session')->pull($key);
    }

    public function validate(array $targets): bool
    {
        foreach ($targets as $input_name => $rules) {
            foreach ($rules as $rule) {
                if ('required' === $rule) {
                    if (!isset($this->inputs[$input_name])) {
                        array_push($this->errors, sprintf('"%s" field is required!', $input_name));
                    }
                }
                if ('min' === explode(':', $rule)[0]) {
                    $min = explode(':', $rule)[1];

                    if (strlen($this->inputs[$input_name]) < $min) {
                        array_push($this->errors, sprintf('"%s" field must be at least %s characters long!', $input_name, $min));
                    }
                }
                if ('max' === explode(':', $rule)[0]) {
                    $max = explode(':', $rule)[1];

                    if (strlen($this->inputs[$input_name]) > $max) {
                        array_push($this->errors, sprintf('"%s" field must be at most %s characters long!', $input_name, $max));
                    }
                }
            }
        }

        if (!empty($this->errors)) {
            app('session')->set('errors', serialize($this->errors));

            $this->flash();

            throw new ValidationException($this->getHeader('referer'));
        }

        return true;
    }

    public function errors(): array|false
    {
        if (app('session')->has('errors')) {
            return unserialize(app('session')->pull('errors'));
        }

        return false;
    }
}