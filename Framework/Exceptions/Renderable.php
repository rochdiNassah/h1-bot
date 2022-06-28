<?php declare(strict_types=1);

namespace Automation\Framework\Exceptions;

interface Renderable
{
    /**
     * Get the exception's associated view name.
     * 
     * @return string
     */
    public function getViewName(): string;

    /**
     * Get the exception's associated http response code.
     * 
     * @return int
     */
    public function getHttpResponseCode(): int;
}