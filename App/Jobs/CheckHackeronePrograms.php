<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Queue\Queueable;
use Automation\Framework\Notifications\Slack;

class CheckHackeronePrograms implements Queueable
{
    public function __construct(
        private Application $app
    ) {

    }

    public function execute(Slack $slack)
    {
        $job_name = app(\ReflectionObject::class, [$this])->getShortName();

        dump(sprintf('Executing "%s" job!', $job_name));

        $message = $slack->channel('debug')->send($job_name);

        if (false !== $message) {
            sleep(4);

            $slack->delete($message);
            
            dump(sprintf('Executed "%s" job successfully!', $job_name));

            return;
        }

        throw new \Exception(sprintf('"%s" job failed!', $job_name));
    }
}