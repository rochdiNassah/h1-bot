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
        $this->assertFalse($fs->missing($path));

        unlink($path);

        $this->assertFalse($fs->exists($path));
        $this->assertTrue($fs->missing($path));
    }
}