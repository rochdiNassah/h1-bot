<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response};
use Automation\Framework\Facades\View;

class ProgramController
{
    public function get(Request $request, Response $response)
    {
        $program = $request->input('program')->length(4, 8);

        $request->validate();

        return View::make('homepage', ['program' => $program]);
    }
}