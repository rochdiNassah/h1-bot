<?php declare(strict_types=1);

define('PROJECT_ROOT', dirname(__DIR__));

require PROJECT_ROOT.'/vendor/autoload.php';

$app = Automation\Core\Application::instance();

$app->run();

class Dependency
{
    public function __toString(): string
    {
        return '55';
    }
}

$resolved = $app->resolve(function (int $a, int $b, int|string $c, Dependency $dependency, int|string $d = 64) {
    return $a + $b + $c + $d + (string) $dependency;
}, ['b' => 3, 'a' => 1, 'a' => 2, 'c' => '4']);

dump($resolved);