<?php declare(strict_types=1);

use Automation\Framework\Facades\{Router, View, Request, Response};

Router::view('/', 'homepage');
Router::view('/program/add', 'program.add');

Router::post('/', function (Automation\Framework\Http\Request $request) {
    Request::validate([
        'program' => ['requires', 'min:2', 'max:512']
    ]);

    Response::redirectBackWith([
        'status' => 'success',
        'message' => 'Program found successfully!'
    ]);
});