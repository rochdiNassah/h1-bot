<?php declare(strict_types=1);

namespace Automation\Framework\Http;

use Automation\Framework\Application;
use Automation\Framework\Routing\Route;

class Response implements ResponseInterface
{
    private array $headers = [];

    private string|null $content = null;

    private int $status_code = 200;

    private array $after_response_hooks = [];

    public function __construct(
        private Application $app
    ) {

    }

    public function addHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    public function getHeader(string $key): string
    {
        return $this->headers[$key];
    }

    private function sendHeaders(): void
    {
        foreach ($this->headers as $key => $value) {
            header(sprintf('%s: %s', $key, $value));
        }

        http_response_code($this->status_code);
    }

    private function sendContent(): void
    {
        print($this->content ?? app(Route::class));
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function redirect(string $to): void
    {
        $this->sendHeaders();

        header(sprintf('Location: %s', $to));
    }

    public function redirectBackWith($data): void
    {
        foreach ($data as $key => $value) {
            app('session')->set($key, $value);
        }

        $this->setStatusCode(301)->redirect(app('request')->getHeader('referer'));
    }

    public function setStatusCode(int $code): self
    {
        $this->status_code = $code;

        return $this;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function registerAfterResponseHook($hook): void
    {
        array_push($this->after_response_hooks, $hook);
    }

    public function runAfterResponseHooks(): void
    {
        foreach ($this->after_response_hooks as $hook) {
            app($hook);
        }
    }
}