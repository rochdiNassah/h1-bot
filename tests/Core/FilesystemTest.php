<?php declare(strict_Types=1);

namespace Tests\Core;

use Automation\Core\Application;

final class FilesystemTest extends TestCase
{
    private $app;

    public function setUp(): void
    {
        $this->app = Application::instance();
    }

    public function test_is_exists(): void
    {
        $fs = $this->app->filesystem;

        $this->assertTrue($fs->exists('composer.json'));
    }
}