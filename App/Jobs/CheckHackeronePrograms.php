<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Interfaces\JobInterface;
use Automation\Framework\Notifications\Slack;
use GuzzleHttp\Client;

class CheckHackeronePrograms implements JobInterface
{
    private Client $client;

    public function __construct(
        private Application $app
    ) {
        $this->client = $app->resolve(Client::class);
    }

    public function __invoke(Slack $slack): bool
    {
        $message = false;

        if (false !== $message) {            
            return true;
        }

        throw new Exception('I failed');
    }
}
