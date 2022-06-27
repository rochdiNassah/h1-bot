<?php declare(strict_types=1);

namespace Automation\Framework\Notifications;

use Automation\Framework\Application;

class Slack
{
    private string $message;

    public function __construct(
        private Application $app
    ) {

    }

    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function send(): void
    {
        echo $this->message;
    }
}