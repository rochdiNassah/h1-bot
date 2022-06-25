<?php declare(strict_types=1);

namespace Automation\Framework\Routing;

use Automation\Framework\Exceptions\RendableInterface;

class NotFoundException extends \Exception implements RendableInterface
{
    public function __construct(string $path)
    {
        $message = sprintf('"%s" not found!.', $path);

        parent::__construct($message);
    }

    public function getView(): string
    {
        return app()->exceptionViews(__CLASS__);
    }
}