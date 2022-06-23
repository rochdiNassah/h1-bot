<?php declare(strict_types=1);

namespace Automation\App\Controllers;

use Automation\Core\Facades\View;

class StringController
{
    public function index()
    {
        return View::make('string');
    }
}