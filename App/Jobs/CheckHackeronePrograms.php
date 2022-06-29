<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Interfaces\JobInterface;
use Automation\Framework\Notifications\Slack;
use Automation\Framework\Facades\Client;
use Automation\Framework\Facades\Filesystem;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class CheckHackeronePrograms implements JobInterface
{
    private Client $client;

    public function __construct(
        private Application $app
    ) {
        $client_options = [
            'base_uri' => 'https://hackerone.com',
            'timeout'  => 10
        ];

        $app->bind(Client::class, app(GuzzleClient::class, [$client_options]));
    }

    public function __invoke(Slack $slack)
    {
        $date_format = 'Y-m-d\TH:i:s\Z';

        $current_date = new \DateTime(date(DATE_RFC3339));

        $current_date->modify('-30 days');

        $json_request = (array) json_decode(file_get_contents(Filesystem::to('resources/json/requests/hackerone/directory.json')));

        $response = Client::request('POST', '/graphql', ['json' => $json_request]);

        if (!$response) {
            throw new \Exception();
        }

        $json_response = json_decode((string) $response->getBody());

        $programs = $json_response->data->teams->edges;

        foreach ($programs as $program) {
            $name        = $program->node->name;
            $handle      = $program->node->handle;
            $launched_at = (new \DateTimeImmutable($program->node->launched_at));

            $current_date->setTimeZone($launched_at->getTimezone());

            if ($launched_at > $current_date) {
                $slack->send(sprintf('(HackerOne) A new program has launched (%s)', $name));
            }
        }

        return true;
    }
}