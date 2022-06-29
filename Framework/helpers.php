<?php declare(strict_types=1);

use Automation\Framework\Facades\{Request, View, Response};
use Automation\Framework\Exceptions\Renderable;

if (!function_exists('session')) {
    function session($key, $value = null): mixed
    {
        if (null === $value) {
            return app('session')->get($key);
        } else {
            return app('session')->set($key, $value);
        }
    }
}
if (!function_exists('errors')) {
    function errors(): array
    {
        return Request::errors() ?? [];
    }
}
if (!function_exists('old')) {
    function old(string $key): string
    {
        return Request::old($key) ?? '';
    }
}
if (!function_exists('config')) {
    function config(string $key): string
    {
        return $_ENV[strtoupper($key)];
    }
}
if (!function_exists('url')) {
    function url(string $to): string
    {
        return sprintf('%s/%s', trim(Request::base_uri(), '\\/'), trim($to, '\\/'));
    }
}
if (!function_exists('escape')) {
    function escape(string $string): string
    {
        return htmlspecialchars($string);
    }
}
if (!function_exists('app')) {
    function app(): mixed
    {
        $app = Automation\Framework\Application::instance();

        if (0 === func_num_args()) {
            return $app;
        }
        if (0 < func_num_args()) {
            return $app->resolve(...func_get_args());
        }
    }
}
if (!function_exists('exception_handler')) {
    function exception_handler($e): void
    {
        if ($e instanceof Renderable) {
            try {
                Response::setStatusCode($e->getHttpResponseCode())
                    ->setContent(View::make($e->getViewName()))
                    ->send();
            } catch (Exception $e) {
                exception_handler($e);
            }

            return;
        }

        dump((new ReflectionObject($e))->getshortName());
        dump("Message: {$e->getMessage()}");
        dump("File: {$e->getFile()}");
        dump("Line: {$e->getLine()}");
    }
}
if (!function_exists('error_handler')) {
    function error_handler(int $errno, string $errstr, string $errfile = '', int $errline = 0, array $errcontext = []): void
    {
        throw new ErrorException($errstr, E_ERROR, $errno, $errfile, $errline);
    }
}
if (!function_exists('dd')) {
    function dd(mixed $data): void
    {
        dump($data);

        die;
    }
}
if (!function_exists('dump')) {
    function dump(mixed $data): void
    {
        $is_cli = php_sapi_name() === 'cli';

        print($is_cli ? null : '<pre>');
        is_null($data) || is_bool($data) ? var_dump($data) : print_r($data);
        print($is_cli ? PHP_EOL : '</pre>');
    }
}
