<?php declare(strict_types=1);

namespace Automation\Framework\Exceptions;

interface RedirectableInterface
{
    /**
     * Get the exception's associated redirection path.
     * 
     * @return string
     */
    public function getRedirectionPath(): string;

    /**
     * Get the exception's associated http response code.
     * 
     * @return int
     */
    public function getHttpResponseCode(): int;
}