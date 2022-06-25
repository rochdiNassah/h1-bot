<?php declare(strict_types=1);

use Automation\Core\Facades\{Router, View};
use Automation\App\Controllers\StringManipulationController;

Router::get('/', function () {
    return View::make('homepage');
});
