<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;

class CheckHackeronePrograms
{
    public function __construct(
        private Application $app
    ) {

    }
}