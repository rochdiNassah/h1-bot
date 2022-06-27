<?php declare(strict_types=1);

namespace Automation\Framework\Http;

use Automation\Framework\Application;

class Session
{
    public function __construct(
        private Application $app
    ) {
        
    }

    public function start(): void
    {
        session_name(config('APP_NAME'));
        session_start();
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function missing(string $key): bool
    {
        return !$this->has($key);
    }

    public function get(string $key): string|null
    {
        return $_SESSION[$key] ?? null;
    }

    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function pull(string $key): string|null
    {
        $item = $this->get($key);

        $this->forget($key);

        return $item;
    }

    public function forget(string $key): void
    {
        unset($_SESSION[$key]);
    }
}