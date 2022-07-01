<?php declare(strict_types=1);

namespace Automation\Framework\Notifications;

use Automation\Framework\Application;
use GuzzleHttp\Client;

class Slack
{
    private string $token;

    private string $channel;

    private Client $client;

    public function __construct(
        private Application $app
    ) {
        $this->token = config('SLACK_OAUTH_TOKEN');

        $client_options = [
            'base_uri' => 'https://slack.com/api/'
        ];

        $this->client = $app->resolve(Client::class, [$client_options]);
    }
    
    private function request(string $method, string $endpoint, array $options = []): mixed
    {
        $headers = [
            'Authorization' => sprintf('Bearer %s', $this->token)
        ];

        $options = array_merge($options, [
            'headers' => $headers,
        ]);

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

        $response = json_decode((string) $this->request('POST', 'chat.postMessage', ['form_params' => $form])->getBody());

        if ($response->ok) {
            $response->message->channel = $response->channel;

            return $response->message;
        }

        return false;
    }

    public function delete(object $message): bool
    {
        $form = [
            'channel' => $message->channel,
            'ts'      => $message->ts
        ];

        $response = json_decode((string) $this->request('POST', 'chat.delete', ['form_params' => $form])->getBody());

        if ($response->ok) {
            return true;
        }

        return false;
    }

    /**
     * Retrieve all messages from a channel then delete them one by one every 1 second to avoid 429 response.
     * 
     * @param  string  $channel_id
     * @return bool
     */
    public function deleteAll(): bool
    {
        $channel_id = $this->getChannelIdByName($this->channel);

        $query = [
            'channel' => $channel_id,
        ];

        $response = json_decode((string) $this->request('GET', 'conversations.history', ['query' => $query])->getBody());

        if ($response->ok) {
            $messages = $response->messages;

            foreach ($messages as $message) {
                $message->channel = $channel_id;

                sleep(1);

                $this->delete($message);
            }

            return true;
        }

        return false;
    }

    public function getChannelIdByName(string $name): string|bool
    {
        $response = json_decode((string) $this->request('GET', 'conversations.list')->getBody());

        if ($response->ok) {
            foreach ($response->channels as $channel) {
                if ($channel->name === $name) {
                    return $channel->id;
                }
            }
        }

        return false;
    }
}