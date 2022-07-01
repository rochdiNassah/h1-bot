<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response};
use Automation\Framework\Facades\{View, Slack, DB};

class DebugController
{
    public function debug()
    {
        Slack::channel('debug')->deleteAll();
    }

    public function view()
    {
        return View::make('debug');
    }

    public function post(Request $request)
    {
        $first_name = $request->input('first_name')->length(4, 16);
        $last_name  = $request->input('last_name')->length(4);

        $request->validate();

        return 'success';
    }
}