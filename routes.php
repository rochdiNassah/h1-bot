<?php declare(strict_types=1);

use Automation\Framework\Facades\{Router, View, Request, Response};

Router::view('/', 'homepage');
Router::view('/program/add', 'program.add');

Router::post('/', function (Automation\Framework\Http\Request $request) {
    $request->validate([
        'program' => ['required', 'min:4', 'max:6']
    ]);

    Response::redirectBackWith(['status' => 'success']);

    return 'fff';
});