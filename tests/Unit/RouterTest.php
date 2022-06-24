<?php declare(strict_types=1);

namespace Tests\Unit;

use Automation\Core\Routing\Router;
use Automation\Core\Http\Request;

final class RouterTest extends TestCase
{
    public function testFoo(): void
    {
        $request = self::make_accessible(app(Request::class));
        $router  = self::make_accessible(app(Router::class));


        $this->assertTrue(true);
    }
}