<?php declare(strict_Types=1);

namespace Tests\Core;

use Automation\Core\Filesystem;

final class FilesystemTest extends TestCase
{
    public function test_is_exists(): void
    {
        dump((string) app(Filesystem::class));
    }
}