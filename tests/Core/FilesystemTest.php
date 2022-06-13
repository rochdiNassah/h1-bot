<?php declare(strict_Types=1);

namespace Tests\Core;

use Automation\Core\Filesystem;

final class FilesystemTest extends TestCase
{
    public function test_path_existence(): void
    {
        $fs = app(Filesystem::class);

        $file_path = 'tests/Core/foo';
        $dir_path  = 'tests/Core/bar';

        fopen((string) $fs->to($file_path), 'w+');
        if (!file_exists((string) $fs->to($dir_path))) mkdir((string) $fs->to($dir_path));

        $this->assertTrue($fs->exists([$file_path, $dir_path]));
        $this->assertTrue($fs->to($file_path)->exists());
        $this->assertTrue($fs->to($dir_path)->exists());
        $this->assertFalse($fs->missing([$file_path, $dir_path]));
        $this->assertFalse($fs->to('tests/Core')->missing(['foo', 'bar']));
        $this->assertFalse($fs->to($file_path)->missing());
        $this->assertFalse($fs->to($dir_path)->missing());

        unlink($file_path);
        
        if (is_dir($dir_path)) rmdir($dir_path);

        $this->assertFalse($fs->exists([$file_path, $dir_path]));
        $this->assertTrue($fs->missing([$file_path, $dir_path]));
        $this->assertTrue($fs->to('tests/Core')->missing(['foo', 'bar']));
    }
}