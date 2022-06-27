<?php declare(strict_types=1);

use Automation\Framework\Facades\Router;
use App\Controllers\ProgramController;
use App\Controllers\DebugController;

Router::view('/', 'homepage');
Router::post('/', [ProgramController::class, 'get']);

Router::get('programs', [ProgramController::class, 'all']);

Router::view('/programs/add', 'program.add');
Router::post('/programs/add', [ProgramControler, 'add']);

Router::get('/programs/{id}/update', [ProgramController::class, 'updateView']);
Router::post('/programs/{id}/update', [ProgramControler, 'update']);

Router::get('/programs/{id}/delete', [ProgramControler, 'delete']);

Router::get('/debug', [DebugController::class, 'get']);
Router::post('/debug', [DebugController::class, 'post']);
Router::head('/debug', [DebugController::class, 'head']);
Router::delete('/debug', [DebugController::class, 'delete']);
Router::options('/debug', [DebugController::class, 'options']);
