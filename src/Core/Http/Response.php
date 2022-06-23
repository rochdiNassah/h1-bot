<?php declare(strict_types=1);

namespace Automation\Core\Http;

use Automation\Core\Application;
use Automation\Core\Routing\Route;

class Response implements ResponseInterface
{
    private array $headers = [];

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
        print(app(Route::class));
    }

    public function send(): void
    {
        $this->send_headers();
        $this->send_content();
    }
}