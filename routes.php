<?php declare(strict_types=1);

use Automation\Core\Facades\Router;
use Automation\App\Controllers\UserController;

Router::get('post/{pid}/comments/{cid}', function ($pid, $cid) {
    return ['Post ID is: ' . $pid, 'Comment ID id ' . $cid];
});

Router::get('/', function () {
    return 'Home page!';
});

Router::get('/users/{id}/name', [UserController::class, 'getName']);