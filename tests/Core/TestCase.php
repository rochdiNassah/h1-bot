<?php declare(strict_types=1);

namespace Tests\Core;

use Automation\Core\Application;

class TestCase extends \PHPUnit\Framework\TestCase
{
    private $app;

    public function setUp(): void
    {
        define('PROJECT_ROOT', dirname(__DIR__));

        $this->app = Application::instance();

        $this->app->run();
    }

}