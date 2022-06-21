<?php declare(strict_Types=1);

namespace Tests\Unit;

use Automation\Core\Filesystem\Filesystem;

final class FilesystemTest extends TestCase
{
    public function test_path_existence(): void
    {
        $fs = app(Filesystem::class);

        $file_path = 'tests/Unit/foo';
        $dir_path  = 'tests/Unit/bar';

        fopen((string) $fs->to($file_path), 'w+');

        if (!file_exists((string) $fs->to($dir_path))) mkdir((string) $fs->to($dir_path));

        $this->assertTrue($fs->exists([$file_path, $dir_path]));
        $this->assertTrue($fs->to($file_path)->exists());
        $this->assertTrue($fs->to($dir_path)->exists());
        $this->assertFalse($fs->missing([$file_path, $dir_path]));
        $this->assertFalse($fs->to('tests/Unit')->missing(['foo', 'bar']));
        $this->assertFalse($fs->to($file_path)->missing());
        $this->assertFalse($fs->to($dir_path)->missing());

        unlink($file_path);
        
        if (is_dir($dir_path)) rmdir($dir_path);

        $this->assertFalse($fs->exists([$file_path, $dir_path]));
        $this->assertTrue($fs->missing([$file_path, $dir_path]));
        $this->assertTrue($fs->to('tests/Unit')->missing(['foo', 'bar']));
    }

    public function test_root_path_is_updatable(): void
    {
        $fs = app(Filesystem::class);

        $current_root = (string) $fs;

        $fs->update_root('/path/to');

        $this->assertSame('/path/to', (string) $fs);

        $fs->reset_root($current_root);

        $this->assertSame($current_root, $fs->old_root());
    }

    public function test_path_renaming(): void
    {
        $fs = app(Filesystem::class);

        $fs->update_root((string) $fs->to('tests/Unit'));

        fopen((string) $fs->to('foo'), 'w+');
        mkdir((string) $fs->to('bar'));

        $this->assertTrue($fs->exists(['foo', 'bar']));

        $this->assertTrue($fs->rename('foo', 'baz'));
        $this->assertTrue($fs->rename('bar', 'qux'));

        $this->assertTrue($fs->missing(['foo', 'bar']));

        $this->assertTrue($fs->exists(['baz', 'qux']));

        $fs->remove(['baz', 'qux']);
    }
}