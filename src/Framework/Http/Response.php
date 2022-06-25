<?php declare(strict_types=1);

namespace Automation\Framework\Http;

use Automation\Framework\Application;
use Automation\Framework\Routing\Route;

class Response implements ResponseInterface
{
    private array $headers = [];

    private $content = null;

    public function __construct(
        private Application $app
    ) {

    }

    public function add_header(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function headers(): array
    {
        return $this->headers;
    }

    private function send_headers(): void
    {
        foreach ($this->headers as $key => $value) {
            header(sprintf('%s: %s', $key, $value));
        }
    }

    private function send_content(): void
    {
        print($this->content ?? app(Route::class));
    }

    public function send(): void
    {
        $this->send_headers();
        $this->send_content();
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
}