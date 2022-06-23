<?php declare(strict_types=1);

namespace Automation\App\Controllers;

class UserController
{
    public function getName(int $id)
    {
        if (1 === $id) {
            return 'Rochdi';
        }

        return 'Unknown user!';
    }
}