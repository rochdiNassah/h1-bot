<?php declare(strict_types=1);

namespace Automation\Framework\Notifications;

use Automation\Framework\Application;
use GuzzleHttp\Client;

class Slack
{
    private string $channel;

    private Client $client;

    public function __construct(
        private string $bot_user_oauth_token,
        private Application $app
    ) {
        $client_options = [
            'base_uri' => 'https://slack.com/api/'
        ];

        $this->client = $app->resolve(Client::class, [$client_options]);
    }
    
    private function request(string $method, string $endpoint, mixed $form = []): mixed
    {
        $options = [
            'headers'     => ['Authorization' => sprintf('Bearer %s', $this->bot_user_oauth_token)],
            'form_params' => $form
        ];

        return $this->client->request($method, $endpoint, $options);
    }

    public function channel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function send($message)
    {
        $form = [
            'channel' => $this->channel,
            'text'    => $message
        ];

        $response = json_decode((string) $this->request('POST', 'chat.postMessage', $form)->getBody());

        if ($response->ok) {
            $response->message->channel = $response->channel;

            return $response->message;
        }

        return false;
    }

    public function delete(object $message)
    {
        $form = [
            'channel' => $message->channel,
            'ts'      => $message->ts
        ];

        $response = json_decode((string) $this->request('POST', 'chat.delete', $form)->getBody());

        if ($response->ok) {
            return true;
        }

        return false;
    }
}