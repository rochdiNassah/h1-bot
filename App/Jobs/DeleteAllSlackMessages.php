<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Interfaces\JobInterface;

class DeleteAllSlackMessages implements JobInterface
{
    public function __construct(
        private Application $app
    ) {
        
    }

    public function __invoke(Slack $slack)
    {
        if (false !== $slack->channel('debug')->deleteAll()) {
            $slack->send('Delete all messages from "debug" channel!');

            return true;
        }

        throw new \Exception('Failed to delete messages from "debug" channel!');
    }
}