<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response};
use Automation\Framework\Facades\View;

class ProgramController
{
    public function get(Request $request, Response $response)
    {
        if ($request->missing('program')) {
            $request->flash();
            $response->backWith(['status' => 'error', 'message' => 'Program field is required.']);
        }

        $program = $request->input('program');

        if (strlen($program) < 2) {
            $request->flash();
            $response->backWith(['status' => 'error', 'message' => 'Program name must be at least 2 characters long.']);
        } elseif (strlen($program) > 256) {
            $request->flash();
            $response->backWith(['status' => 'error', 'message' => 'Program name must be at most 256 characters long.']);
        }

        return View::make('homepage', ['program' => $program]);
    }
}