<?php declare(strict_types=1);

namespace Tests\Core;

use Automation\Core\Application;

final class ApplicationTest extends TestCase
{
    public function test_resolving_dependencies(): void
    {
        $app = Application::instance();

        $resolved = $app->resolve(function (): string {
            return 'foo';
        });

        $this->assert
    }
}