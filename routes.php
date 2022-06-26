<?php declare(strict_types=1);

use Automation\Framework\Facades\Router;
use App\Controllers\ProgramController;
use App\Controllers\DebugController;

Router::get('/debug', [DebugController::class, 'get']);
Router::post('/debug', [DebugController::class, 'post']);
Router::head('/debug', [DebugController::class, 'head']);
Router::options('/debug', [DebugController::class, 'options']);

Router::view('/', 'homepage');
Router::view('/program/add', 'program.add');

Router::post('/', [ProgramController::class, 'get']);