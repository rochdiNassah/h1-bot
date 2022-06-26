<?php declare(strict_types=1);

use Automation\Framework\Facades\Router;
use App\Controllers\ProgramController;

Router::view('/', 'homepage');
Router::view('/program/add', 'program.add');

Router::post('/', [ProgramController::class, 'get']);