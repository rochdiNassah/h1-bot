<?php declare(strict_types=1);

use Automation\Framework\Facades\{Request, View, Response};
use Automation\Framework\Exceptions\Renderable;
use Automation\Framework\Exceptions\Redirectable;

if (!function_exists('time_ago')) {
    // TODO (Refactoring)
    function time_ago($time): string|null
    {
        if (is_null($time)) {
            return null;
        }

        $diff = time() - $time;

        if ($diff < 60) {
            if (0 === $diff) {
                return 'Just now';
            }

            $result = [$diff, 'seconds'];
        }
        if ($diff >= 60 && $diff < 3600) {
            $result = [$diff / 60, 'minutes'];
        }
        if ($diff >= 3600 && $diff < 86400) {
            $result = [$diff / 60 / 60, 'hours'];
        }
        if ($diff >= 86400 && $diff < 604800) {
            $result = [$diff / 60 / 60 / 24, 'days'];
        }
        if ($diff >= 604800 && $diff < 2592000) {
            $result = [$diff / 60 / 60 / 24 / 7, 'weeks'];
        }
        if ($diff >= 2592000 && $diff < 31104000) {
            $result = [$diff / 60 / 60 / 24 / 30, 'months'];
        }
        if ($diff >= 31104000) {
            $result = [$diff / 60 / 60 / 24 / 30 / 12, 'years'];
        }

        $string  = $result[1];
        $decimal = round($result[0]);

        if ($decimal === 1) {
            $string = substr($string, 0, -1);
        }

        return sprintf('%d %s ago', $decimal, $string);
    }
}
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

        if ($e instanceof Redirectable) {
            try {
                Response::setStatusCode($e->getHttpResponseCode())
                    ->redirect($e->getDestination());
            } catch (Exception $e) {
                exception_handler($e);
            }

            return;
        }

        dump((new ReflectionObject($e))->getShortName());
        dump("Message: {$e->getMessage()}");
        dump("File: {$e->getFile()}");
        dump("Line: {$e->getLine()}");
    }
}
if (!function_exists('error_handler')) {
    function error_handler(int $errno, string $errstr, string $errfile = '', int $errline = 0, array $errcontext = []): void
    {
        throw new ErrorException($errstr, $errno, E_ERROR, $errfile, $errline);
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
