<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response, Session};
use Automation\Framework\Facades\View;
use Automation\Framework\Facades\DB;

class ProgramController
{
    public function add(Request $request, Session $session, Response $response)
    {
        $platforms = ['hackerone'];

        $name     = $request->input('name')->required()->missingFrom('programs', 'name');
        $root     = $request->input('root')->required();
        $platform = $request->input('platform')->required()->in($platforms);

        $request->validate();

        $stmt = DB::prepare('INSERT INTO programs(`name`, root_domain, created_at) VALUES(?, ?, ?)');

        $result = $stmt->execute([$name, $root, time()]);

        if (!$result) {
            $request->addError('', 'Something went wrong!');
        
            return $request->back();
        }

        $session->set('message', 'Program added!');

        return View::make('homepage');
    }
}
