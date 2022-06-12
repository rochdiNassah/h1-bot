<?php declare(strict_types=1);

namespace Tests\Core;

use Automation\Core\Application;

final class ApplicationTest extends TestCase
{
    public function test_closure_is_resolvable(): void
    {
        $app = Application::instance();

        $resolved = $app->resolve(function (): string {
            return 'foo';
        });

        $this->assertSame($resolved, 'foo');

        $resolved = $app->resolve(function (int $a, int $b, int|string $c, Dependency $dependency, int|string $d = 64) {
            return $a + $b + $c + $d + (string) $dependency;
        }, ['b' => 3, 'a' => 1, 'a' => 2, 'c' => '4']);

        $this->assertSame($resolved, 128);
    }
}

class Dependency
{
    public function __toString(): string
    {
        return '55';
    }
}