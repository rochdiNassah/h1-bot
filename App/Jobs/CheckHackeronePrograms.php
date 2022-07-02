<?php declare(strict_types=1);

namespace App\Jobs;

use Automation\Framework\Application;
use Automation\Framework\Interfaces\JobInterface;
use Automation\Framework\Facades\Client;
use Automation\Framework\Facades\Filesystem;
use Automation\Framework\Facades\DB;
use Automation\Framework\Facades\Slack;
use GuzzleHttp\Client as GuzzleClient;

class CheckHackeronePrograms implements JobInterface
{
    private string $base_uri;

    private Client $client;

    public function __construct(
        private Application $app
    ) {
        $this->base_uri = 'https://hackerone.com';

        $client_options = [
            'base_uri' => $this->base_uri,
            'timeout'  => 20
        ];

        $app->bind(Client::class, app(GuzzleClient::class, [$client_options]));
    }

    public function __invoke()
    {
        try {
            $this->checkForNewPrograms();
            $this->checkForNewAssets();

            return true;
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    private function checkForNewPrograms(): bool
    {
        $date_format = 'Y-m-d\TH:i:s\Z';

        $current_date = new \DateTime(date(DATE_RFC3339));

        $current_date->modify(sprintf('-%s minutes', app('sleep_for') * 2 - 1));

        $json_request = json_decode(file_get_contents(Filesystem::to('resources/json/requests/hackerone/directory.json')));

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

            $current_date->setTimezone($launched_at->getTimezone());

            if ($launched_at > $current_date) {
                $message = sprintf('H1 new program launch <%s/%s>', $this->base_uri, $handle);

                Slack::send($message);
            }

            return true;
        }

        throw new \Exception();
    }

    private function checkForNewAssets(): bool
    {
        $stmt = DB::prepare('SELECT * FROM programs');

        $stmt->execute();

        $programs = $stmt->fetchAll(\PDO::FETCH_OBJ);

        $json_request = json_decode(file_get_contents(Filesystem::to('resources/json/requests/hackerone/assets.json')));

        foreach ($programs as $program) {
            $json_request->variables->handle = $program->handle;

            $response       = json_decode((string) Client::request('POST', '/graphql', ['json' => $json_request])->getBody());
            $old_assets     = json_decode($program->assets);
            $current_assets = [];
            
            if ($response) {
                foreach ($response->data->team->in_scope_assets->edges as $asset) {
                    array_push($current_assets, $asset->node->asset_identifier);
                }

                $diff = array_diff($current_assets, $old_assets);

                if (!empty($diff)) {
                    foreach ($diff as $new_asset) {
                        array_push($old_assets, $new_asset);
    
                        Slack::send(sprintf('(HackerOne) New asset for %s (%s).', ucfirst($program->handle), $new_asset));
                    }

                    $stmt = DB::prepare('UPDATE programs SET assets = ? WHERE handle = ?');

                    $stmt->execute([json_encode($old_assets), $program->handle]);
                }
            }
        }

        return true;
    }
}
