<?php declare(strict_types=1);

namespace Automation\Framework\View;

class ViewFactory
{
    public static function make(string $view, array $data = []): string
    {
        $view = app(View::class, [$view, $data]);

        $view->render();

        return $view->content();
    }
}
