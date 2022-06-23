<?php declare(strict_types=1);

namespace Automation\Core\View;

use Automation\Core\Application;
use Automation\Core\Facades\Application as ApplicationFacade;

class ViewFactory
{
    public static function make(string $view, array $data = []): string
    {
        $view = ApplicationFacade::resolve(View::class, [$view, $data]);

        $view->render();

        return $view->content();
    }
}