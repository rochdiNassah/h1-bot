<?php declare(strict_types=1);

namespace Automation\Core\Routing;

class NotFoundException extends \Exception
{
    public function __construct(string $path)
    {
        $message = sprintf('"%s" not found!.', $path);

        parent::__construct($message);
    }
}