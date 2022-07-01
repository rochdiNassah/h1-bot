<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Facades\DB;
use Automation\Framework\Facades\Response;

class InstallationController
{
    public function __invoke()
    {
        $db_name = config('DB_NAME');

        try {
            DB::connectToServer();

            DB::exec(sprintf('DROP DATABASE IF EXISTS %s', $db_name));
            DB::exec(sprintf('CREATE DATABASE IF NOT EXISTS %s', $db_name));
        
            DB::exec(sprintf('USE %s', $db_name));
        
            DB::exec('CREATE TABLE IF NOT EXISTS programs (
                id INT(11) PRIMARY KEY AUTO_INCREMENT,
                handle VARCHAR(512) NOT NULL UNIQUE,
                created_at INT(11) NOT NULL,
                updated_at INT(11) NULL
            )');

            app('session')->set('message', 'Installation done!');
        } catch (\Throwable) {
            app('session')->set('error', 'Something went wrong with the installation! <a class="font-bold" href="'.url('/install').'">Reinstall!</a>');
        }

        Response::setStatusCode(301)->redirect('/');
    }
}