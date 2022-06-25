<?php declare(strict_types=1);

namespace Automation\Framework\Utilities;

use Automation\Framework\Application;

class StringUtility
{
    public function __construct(
        private string $string,
        private Application $app
    ) {

    }

    public function length(): int
    {
        return strlen($this->string);
    }

    public function reverse(): string
    {
        return strrev($this->string);
    }
}