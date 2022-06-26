<?php declare(strict_types=1);

namespace Tests\Unit;

use Automation\Framework\Routing\{Router, Route, NotFoundHttpException};
use Automation\Framework\Http\Request;

final class RouterTest extends TestCase
{
    public function test_route_matching(): void
    {
        $request = app()->resolve(Request::class, share: true);
        $router  = app(Router::class);
        
        $pid = rand(8, 4096):
        $cid = rand(8, 4096);

        $router->get('/posts/{pid}/comments/{cid}', [Controller::class, 'echo']);

        $request->simulate('GET', "/posts/{$pid}/comments/{$cid}");

        $router->run();

        $this->assertEquals([$pid, $cid], app(Route::class)->result());

        $this->expectException(NotFoundHttpException::class);

        $request->simulate('GET', "/posts//comments/{$cid}");

        $router->run();
    }
}

class Controller
{
    public function echo(...$args): array
    {
        return array_values($args);
    }
}
