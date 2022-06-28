<?php declare(strict_types=1);

namespace Automation\Framework\Routing;

use Automation\Framework\Exceptions\Renderable;

class NotFoundHttpException extends \Exception implements Renderable
{
    public function __construct(string $path)
    {
        $message = sprintf('"%s" not found!.', $path);

        parent::__construct($message);
    }

    public function getViewName(): string
    {
        return 'exceptions.404';
    }

    public function getHttpResponseCode(): int
    {
        return 404;
    }
}