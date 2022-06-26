<?php declare(strict_types=1);

namespace App\Controllers;

use Automation\Framework\Http\{Request, Response};
use Automation\Framework\Facades\View;

class DebugController
{
    public function get(Request $request, Response $response)
    {
        return View::make('debug');
    }

    public function post(Request $request)
    {
        dump($_FILES);

        dump($request->input('file'));

        echo sprintf('<a href="%s">Back</a>', url('/debug'));
    }
}