<?php declare(strict_types=1);

define('PROJECT_ROOT', dirname(__DIR__));

require PROJECT_ROOT.'/vendor/autoload.php';

$app = Automation\Core\Application::instance();

$app->run();

class Dependency
{

}

$app->resolve(function (string $name, Dependency $dependency): void {
    dump($name);
    dump($dependency);
}, ['rochdi']);