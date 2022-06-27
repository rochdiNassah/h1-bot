<?php declare(strict_types=1);

namespace Automation\Framework\Notifications;

use Automation\Framework\Application;

class Slack
{
    public function __construct(
        private Application $app
    ) {

    }

    public function send(string $message): string
    {
        return $message;
    }
}