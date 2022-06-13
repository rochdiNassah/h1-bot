<?php declare(strict_Types=1);

namespace Tests\Core;

use Automation\Core\Filesystem;

final class FilesystemTest extends TestCase
{
    public function test_path_existence(): void
    {
        $fs = app(Filesystem::class);

        $path = 'tests/Core/foo';

        fopen((string) $fs->to($path), 'w+');

        $this->assertTrue($fs->exists($path));
        $this->assertTrue($fs->to($path)->exists());
        $this->assertFalse($fs->missing($path));
        $this->assertFalse($fs->to('tests/Core')->missing('foo'));
        $this->assertFalse($fs->to('tests/Core/foo')->missing());

        unlink($path);

        $this->assertFalse($fs->exists($path));
        $this->assertTrue($fs->missing($path));
        $this->assertTrue($fs->to('tests/Core')->missing('foo'));
    }
}