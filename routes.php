<?php declare(strict_types=1);

use Automation\Core\Facades\Router;
use Automation\App\Controllers\StringController;

Router::get('/string-manipulation', [StringController::class, 'index']);
Router::post('/string-manipulation', [StringController::class, 'eval']);