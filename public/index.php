<?php declare(strict_types=1);

require '../vendor/autoload.php';

use Automation\Core\Facades\{Request, Filesystem, Router, Encoder};

$app = Automation\Core\Application::instance();

$app->run();

echo (app(Automation\Core\Routing\Route::class));