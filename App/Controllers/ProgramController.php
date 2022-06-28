<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response};
use Automation\Framework\Facades\View;

class ProgramController
{
    public function get()
    {
        return View::make('homepage');
    }
}
