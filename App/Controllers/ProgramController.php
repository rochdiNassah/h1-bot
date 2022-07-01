<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response, Session};
use Automation\Framework\Facades\View;
use Automation\Framework\Facades\DB;

class ProgramController
{
    public function add(Request $request, Session $session, Response $response)
    {
        $handle = $request->input('handle')->required()->missingFrom('programs', 'handle');

        $request->validate();

        $stmt = DB::prepare('INSERT INTO programs(handle, created_at) VALUES(?, ?)');

        $result = $stmt->execute([$handle, time()]);

        if (!$result) {
            $request->addError('', 'Something went wrong!');
        
            return $request->back();
        }

        $session->set('message', 'Program added!');

        return View::make('homepage');
    }
}
