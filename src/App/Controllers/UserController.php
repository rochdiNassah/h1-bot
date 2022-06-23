<?php declare(strict_types=1);

namespace Automation\App\Controllers;

use Automation\Core\Facades\View;

class UserController
{
    public function getName(int $id)
    {
        if (1 === $id) {
            return View::make('users', ['name' => 'rochdi']);
        }

        return View::make('users', ['name' => 'Unknown!']);
    }
}