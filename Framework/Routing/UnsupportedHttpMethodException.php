<?php declare(strict_types=1);

namespace Automation\Framework\Routing;

class UnsupportedHttpMethodException extends \Exception
{
    public function __construct(string $method)
    {
        $message = sprintf('"%s" is not a supported HTTP method.', $method);

        parent::__construct($message);
    }
}