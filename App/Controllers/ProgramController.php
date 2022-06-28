<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response};
use Automation\Framework\Facades\View;

class ProgramController
{
    public function show(Request $request)
    {
        $program = $request->input('program')->length(4, 16);

        $request->validate();

        return $program;
    }
}
