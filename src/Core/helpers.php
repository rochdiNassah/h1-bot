<?php declare(strict_types=1);

if (!function_exists('_decode')) {
    function _decode(string $string, string $as): string
    {
        if ('base64' === $as) {
            return base64_decode($string, true);
        }
        if ('html' === $as) {
            return html_entity_decode($string);
        }
        if ('url' === $as) {
            return urldecode($string);
        }
    }
}
if (!function_exists('_encode')) {
    function _encode(string $string, string $as): string
    {
        if ('base64' === $as) {
            return base64_encode($string);
        }
        
        $formats = [
            'html' => '&#x%s;',
            'url'  => '%%%s'
        ];

        if (!array_key_exists($as, $formats)) {
            throw new Exception(sprintf('"%s" is not a supported encoding type.', $as));
        }

        $format = $formats[$as];

        $characters = array_map(function ($item) use ($format) {
            return sprintf($format, $item);
        },  str_split(bin2hex($string), 2));

        return implode($characters);
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