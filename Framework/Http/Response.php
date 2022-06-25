<?php declare(strict_types=1);

namespace Automation\Framework\Http;

use Automation\Framework\Application;
use Automation\Framework\Routing\Route;

class Response implements ResponseInterface
{
    private array $headers = [];

    private $content = null;

    private int $status_code = 200;

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

        header(sprintf('Location: %s', url($to)));
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
}