<?php declare(strict_types=1);

namespace Tests;

use ReflectionObject;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public static function setUpBeforeClass(): void
    {
        \Automation\Framework\Application::instance(recreate: true)->run();
    }
}