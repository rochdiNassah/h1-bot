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

        $router->get('/posts/{pid}/comments/{cid}', [Controller::class, 'echo']);

        $request->simulate('GET', "/posts/32/comments/64");

        $router->run();

        $this->assertEquals([32, 64], app(Route::class)->result());

        $this->expectException(NotFoundHttpException::class);

        $request->simulate('GET', "/posts//comments/128");

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