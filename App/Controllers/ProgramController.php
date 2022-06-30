<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response, Session};
use Automation\Framework\Facades\View;
use Automation\Framework\Facades\DB;


class ProgramController
{
    public function add(Request $request, Session $session, Response $response)
    {
        $name = $request->input('name')->length(4, 256);
        $root = $request->input('root')->length(8, 256);

        $request->validate();

        $stmt = DB::prepare('INSERT INTO programs(`name`, root_domain, created_at) VALUES(?, ?, ?)');

        $result = $stmt->execute([$name, $root, time()]);

        if (!$result) {
            $request->setError('', 'Something went wrong!');
        
            $request->back();
        }

        $session->set('message', 'Program added!');

        return View::make('homepage');
    }
}
