<?php declare(strict_types=1);

namespace Tests;

use Automation\Framework\Application;

final class ApplicationTest extends TestCase
{
    public function test_closure_is_resolvable(): void
    {
        $closure = function (): string {
            return 'foo';
        };

        $this->assertSame(app($closure), 'foo');

        $closure = function (int $a, int $b, int|string $c, Dependency $dependency, int|string $d = 16): int {
            return $a * $b * $c * $d / (string) $dependency;
        };

        $resolved = app($closure, ['b' => 4, 'a' => 9999, 'a' => 32, 'c' => '64']);

        $this->assertSame($resolved, 1024);
    }

    public function test_class_is_resolvable(): void
    {
        $instance_one = app(Dependency::class);
        $instance_two = app(Dependency::class);

        $this->assertInstanceOf(Dependency::class, app(Dependency::class));

        $this->assertNotSame($instance_one, $instance_two);

        $instance_three = app(Dependency::class, ['b' => 'qux'], true);
        $instance_four  = app(Dependency::class);

        $this->assertSame($instance_three, $instance_four);
    }
}

class Dependency
{
    public function __construct(
        private DependencyTwo $dependency_two,
        private DependencyThree $dependency_three,
        private DependencyFour $dependency_four,
        private DependencyFive $dependency_five,
        private string $a = 'foo',
        private string $b = 'bar',
        private string $c = 'baz'
    ) {

    }

    public function __toString(): string
    {
        return (string) $this->dependency_two;
    }
}

class DependencyTwo {
    public function __toString(): string
    {
        return '128';
    }
}
class DependencyThree {}
class DependencyFour {
    public function __construct(
        private DependencyTwo $dependency_two
    ) {

    }
}
class DependencyFive {}