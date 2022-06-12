<?php declare(strict_Types=1);

namespace Tests\Core;

final class FilesystemTest extends TestCase
{
    public function test_is_exists(): void
    {
        $fs = $this->app->filesystem;

        $this->assertTrue($fs->exists('composer.json'));
    }
}