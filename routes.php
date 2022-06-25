<?php declare(strict_types=1);

use Automation\Framework\Facades\{Router, View};

Router::get('/', function () {
    return View::make('homepage');
});

Router::get('/foo/{param}', function ($param) {
    return $param;
});