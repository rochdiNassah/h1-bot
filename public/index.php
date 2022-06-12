<?php declare(strict_types=1);

require '../vendor/autoload.php';

use Automation\Core\Facades\{Request, Filesystem};

$app = Automation\Core\Application::instance();

$app->run();

class Dependency
{
    public function __construct(
        private string $a = 'foo',
        private string $b = 'bar',
        private string $c = 'baz',
        private DependencyTwo $dependency_two,
        private DependencyThree $dependency_three,
        private DependencyFour $dependency_four,
        private DependencyFive $dependency_five
    ) {

    }

    public function __toString(): string
    {
        return '55';
    }
}

class DependencyTwo {}
class DependencyThree {}
class DependencyFour {}
class DependencyFive {}