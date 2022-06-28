<?php declare(strict_types=1);

use Automation\Framework\Facades\Router;
use App\Controllers\ProgramController;
use App\Controllers\DebugController;

Router::view('/', 'homepage');
Router::post('/', [ProgramController::class, 'get']);

Router::get('programs', [ProgramController::class, 'all']);

Router::view('/programs/add', 'program.add');
Router::post('/programs/add', [ProgramController::class, 'add']);

Router::get('/programs/{id}/update', [ViewController::class, 'updateView']);
Router::post('/programs/{id}/update', [ProgramController::class, 'update']);

Router::get('/programs/{id}/delete', [ProgramController::class, 'delete']);

Router::get('/debug', [DebugController::class, 'debug']);
Router::get('/debug/view', [DebugController::class, 'view']);
Router::post('/debug', [DebugController::class, 'post']);
