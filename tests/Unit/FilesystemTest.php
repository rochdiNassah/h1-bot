<?php declare(strict_Types=1);

namespace Tests\Unit;

use Automation\Core\Filesystem\Filesystem;

final class FilesystemTest extends TestCase
{
    public function test_path_existence(): void
    {
        $fs = app(Filesystem::class);

        $fs->update_root('tests/Unit');

        $file_path = $fs->to('foo');
        $dir_path  = $fs->to('bar');

        fopen($file_path, 'w+');
        @mkdir($dir_path);

        $this->assertTrue($fs->exists([$file_path, $dir_path]));
        $this->assertFalse($fs->missing([$file_path, $dir_path]));

        @unlink($file_path);
        @rmdir($dir_path);

        $this->assertFalse($fs->exists([$file_path, $dir_path]));
        $this->assertTrue($fs->missing([$file_path, $dir_path]));

        $fs->reset_root();
    }

    public function test_root_path_is_updatable(): void
    {
        $fs = app(Filesystem::class);

        $current_root = (string) $fs;

        $fs->update_root('/path/to');

        $this->assertSame('/path/to', (string) $fs);

        $fs->reset_root();

        $this->assertSame($current_root, $fs->old_root());
    }

    public function test_path_renaming(): void
    {
        $fs = app(Filesystem::class);

        $fs->update_root('tests/Unit');

        $file_path = $fs->to('foo');
        $dir_path  = $fs->to('bar');

        fopen($file_path, 'w+');
        @mkdir($dir_path);

        $this->assertTrue($fs->exists([$file_path, $dir_path]));

        $this->assertTrue($fs->rename('foo', 'baz'));
        $this->assertTrue($fs->rename('bar', 'qux'));

        $this->assertTrue($fs->missing([$file_path, $dir_path]));

        $file_path = $fs->to('baz');
        $dir_path  = $fs->to('qux');

        $this->assertTrue($fs->exists([$file_path, $dir_path]));

        $fs->remove(['baz', 'qux']);

        $fs->reset_root();
    }
}