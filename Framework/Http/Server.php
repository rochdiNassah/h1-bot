<?php declare(strict_types=1);

namespace Automation\Framework\Http;

class Server
{
    private array $server;

    public function __construct(

    ) {
        $this->server = $_SERVER;
    }

    public function get(string $key, string $default = null): string|null
    {
        return $this->server[$key] ?? null;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->server);
    }

    public function missing(string $key): bool
    {
        return !$this->has($key);
    }

    public function all(): array
    {
        return $this->server;
    }
}
