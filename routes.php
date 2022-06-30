<?php declare(strict_types=1);

use Automation\Framework\Facades\Router;
use App\Controllers\ProgramController;
use App\Controllers\DebugController;
use App\Controllers\InstallationController;

Router::view('/', 'homepage');

Router::get('programs', [ProgramController::class, 'all']);

Router::view('/programs/add', 'program.add');
Router::post('/programs/add', [ProgramController::class, 'add']);

Router::get('/programs/{id}/delete', [ProgramController::class, 'delete']);

Router::get('/debug', [DebugController::class, 'debug']);
Router::get('/debug/view', [DebugController::class, 'view']);
Router::post('/debug', [DebugController::class, 'post']);

Router::get('/install', InstallationController::class);