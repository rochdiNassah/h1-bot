<?php declare(strict_types=1);

namespace Tests;

use ReflectionObject;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        \Automation\Framework\Application::instance()->run();
    }
}