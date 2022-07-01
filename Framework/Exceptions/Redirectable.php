<?php declare(strict_types=1);

namespace Automation\Framework\Exceptions;

interface Redirectable
{
    /**
     * Get the destination where this exception should be redirected to.
     * 
     * @return string
     */
    public function getDestination(): string;

    /**
     * Get the exception's associated http response code.
     * 
     * @return int
     */
    public function getHttpResponseCode(): int;
}