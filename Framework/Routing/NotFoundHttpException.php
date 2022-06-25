<?php declare(strict_types=1);

namespace Automation\Framework\Routing;

use Automation\Framework\Exceptions\RendableInterface;

class NotFoundHttpException extends \Exception implements RendableInterface
{
    public function __construct(string $path)
    {
        $message = sprintf('"%s" not found!.', $path);

        parent::__construct($message);
    }

    public function getView(): string
    {
        return '404';
    }
}