<?php declare(strict_types=1);

namespace Automation\Framework\Database;

use Automation\Framework\Application;
use PDO;

class Database
{
    private $connection;

    private string $host;

    private string $user;

    private string $pass;

    private string $name;

    public function __construct(
        private Application $app,
        private array $options = []
    ) {
        $this->host = config('DB_HOST');
        $this->user = config('DB_USER');
        $this->pass = config('DB_PASS');
        $this->name = config('DB_NAME');
    }

    public function connection(): PDO
    {
        if (!$this->connection instanceof PDO) {
            $this->connect();
        }

        return $this->connection;
    }

    public function connect(): void
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s', $this->host, $this->name);

        $this->connection = new PDO($dsn, $this->user, $this->pass, $this->options);
    }

    public function connectToServer(): void
    {
        $dsn = sprintf('mysql:host=%s', $this->host);

        $this->connection = new PDO($dsn, $this->user, $this->pass, $this->options);
    }

    public function __call(string $method, array $params = [])
    {
        return $this->connection()->{$method}(...$params);
    }
}