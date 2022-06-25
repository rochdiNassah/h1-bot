<?php declare(strict_types=1);

use Automation\Core\Facades\{Router, View};

Router::get('/', function () {
    return View::make('homepage');
});
