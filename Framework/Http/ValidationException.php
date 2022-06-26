<?php declare(strict_types=1);

namespace Automation\Framework\Http;

use Automation\Framework\Exceptions\RedirectableInterface;

class ValidationException extends \Exception implements RedirectableInterface
{
    private string $redirect_to;

    public function __construct(string $redirect_to)
    {
        $this->redirect_to = $redirect_to;
    }

    public function getRedirectionPath(): string
    {
        return $this->redirect_to;
    }

    public function getHttpResponseCode(): int
    {
        return 429;
    }
}