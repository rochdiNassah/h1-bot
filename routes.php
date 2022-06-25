<?php declare(strict_types=1);

use Automation\Framework\Facades\{Router, View, Request};

Router::view('/', 'homepage');
Router::view('/program/add', 'program.add');

Router::post('/foo', function ($age) {
    return $age;
});