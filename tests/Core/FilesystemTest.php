<?php declare(strict_Types=1);

namespace Tests\Core;

use Automation\Core\Filesystem;

final class FilesystemTest extends TestCase
{
    public function test_path_is_exists(): void
    {
        $fs = app(Filesystem::class);

        fopen((string) $fs->to('tests/Core/foo'), 'x');

        $this->assertTrue($fs->to('tests/Core')->exists('foo'));

        unlink((string) $fs->to('tests/Core/foo'));

        $this->assertFalse($fs->to('tests/Core')->exists('foo'));
    }

    public function test_path_is_missing(): void
    {
        $fs = app(Filesystem::class);

        fopen((string) $fs->to('tests/Core/bar'), 'x');

        $this->assertFalse($fs->to('tests/Core')->missing('bar'));

        unlink((string) $fs->to('tests/Core/bar'));

        $this->assertTrue($fs->to('tests/Core')->missing('bar'));
    }
}