<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response};

class ProgramController
{
    public function get(Request $request, Response $response): void
    {
        $program = $request->input('program');

        $status  = 'error';

        if (is_null($program)) {
            $message = 'Progam field is required.';
        } elseif (strlen($program) < 2) {
            $message = 'Program name must be at least 2 characters long.';
        } elseif (strlen($program) > 512) {
            $message = 'Program name must be at most 256 characters long.';
        } else {
            $status  = 'success';
            $message = 'Program found!';
        }

        $response->backWith(['status' => $status, 'message' => $message]);
    }
}