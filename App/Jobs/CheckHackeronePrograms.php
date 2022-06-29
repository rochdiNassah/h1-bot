<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Interfaces\JobInterface;
use Automation\Framework\Notifications\Slack;
use Automation\Framework\Facades\Client;
use GuzzleHttp\Client as GuzzleClient;

class CheckHackeronePrograms implements JobInterface
{
    private Client $client;

    public function __construct(
        private Application $app
    ) {
        $client_options = [
            'base_uri' => 'https://hackerone.com'
        ];

        $app->bind(Client::class, app(GuzzleClient::class, [$client_options]));
    }

    public function __invoke(Slack $slack): bool
    {
        $response = Client::request('GET', '/directory/programs');

        dump((string) $response->getStatusCode());

        if (false !== $response) {            
            return true;
        }

        throw new Exception('I failed');
    }
}