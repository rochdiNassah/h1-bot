<?php declare(strict_types=1);

namespace Automation\Core\Utilities;

use Automation\Core\Application;

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
}