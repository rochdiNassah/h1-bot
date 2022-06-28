<?php declare(strict_types=1);

use Automation\Framework\Facades\{Router, DB, View, Response};
use App\Controllers\ProgramController;
use App\Controllers\DebugController;

Router::view('/', 'homepage');
Router::post('/', [ProgramController::class, 'show']);

Router::get('programs', [ProgramController::class, 'all']);

Router::view('/programs/add', 'program.add');
Router::post('/programs/add', [ProgramController::class, 'add']);

Router::get('/programs/{id}/update', [ViewController::class, 'updateView']);
Router::post('/programs/{id}/update', [ProgramController::class, 'update']);

Router::get('/programs/{id}/delete', [ProgramController::class, 'delete']);

Router::get('/debug', [DebugController::class, 'debug']);
Router::get('/debug/view', [DebugController::class, 'view']);
Router::post('/debug', [DebugController::class, 'post']);

Router::get('/install', function () {
    $db_name = config('DB_NAME');

    try {
        DB::connectToServer();

        DB::exec(sprintf('DROP DATABASE IF EXISTS %s', $db_name));
        DB::exec(sprintf('CREATE DATABASE IF NOT EXISTS %s', $db_name));
    
        DB::exec(sprintf('USE %s', $db_name));
    
        DB::exec('CREATE TABLE IF NOT EXISTS programs (
            id INT(11) PRIMARY KEY AUTO_INCREMENT,
            `name` VARCHAR(512) NOT NULL,
            root_domain VARCHAR(512) NOT NULL,
            created_at INT(11) NOT NULL,
            updated_at INT(11) NULL
        )');

        app('session')->set('message', 'Installation done!');
    } catch (\Throwable) {
        app('session')->set('error', 'Something went wrong with the installation! <a class="font-bold" href="'.url('/install').'">Reinstall!</a>');
    }

    Response::setStatusCode(301)->redirect('/');
});