<?php declare(strict_types=1);

use Automation\Core\Facades\Filesystem;
use Automation\Core\Filesystem\FileDoesNotExistException;

if (!function_exists('play_audio')) {
    function play_audio(string $audio, int $times = 1): void
    {
        if ('cli' !== php_sapi_name()) {
            return;
        }

        $path = (string) Filesystem::to('resources/audio')->to($audio);

        if (!file_exists($path)) {
            throw new FileDoesNotExistException($path);
        }

        for ($i=0; $i<$times; $i++):
            system(sprintf('cvlc --play-and-exit %s 2>/dev/null', $path));
        endfor;

        return;
    }
}
if (!function_exists('app')) {
    function app(): mixed
    {
        $app = Automation\Core\Application::instance();

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
        dump((new ReflectionObject($e))->getshortName());
        dump("Message: {$e->getMessage()}");
        dump("File: {$e->getFile()}");
        dump("Line: {$e->getLine()}");

        die;
    }
}
if (!function_exists('error_handler')) {
    function error_handler(int $errno, string $errstr, string $errfile = '', int $errline = 0, array $errcontext = []): void
    {
        dump("Error {$errstr}");
        dump("File: {$errfile}");
        dump("Line: {$errline}");

        die;
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

        print($is_cli ? PHP_EOL : '<pre>');
        is_null($data) || is_bool($data) ? var_dump($data) : print_r($data);
        print($is_cli ? PHP_EOL : '</pre>');
    }
}