<?php declare(strict_types=1);

define('PROJECT_ROOT', dirname(__DIR__));

require PROJECT_ROOT.'/vendor/autoload.php';

$app = Automation\Core\Application::instance();

$app->run();

$app->resolve('aaa');