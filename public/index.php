<?php declare(strict_types=1);

define('PROJECT_ROOT', dirname(__DIR__));

require PROJECT_ROOT.'/vendor/autoload.php';

set_error_handler('error_handler');
set_exception_handler('exception_handler');

throw new Exception('Foo');