<?php declare(strict_types=1);

namespace Automation\Framework\View;

class ViewNotFoundHttpException extends \Exception
{
    public function __construct(string $view)
    {
        parent::__construct(sprintf('"%s" view does not exist.', $view));
    }
}