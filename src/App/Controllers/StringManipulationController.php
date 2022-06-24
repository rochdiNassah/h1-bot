<?php declare(strict_types=1);

namespace Automation\App\Controllers;

use Automation\Core\Facades\{View, Request};
use Automation\Core\Utilities\StringUtility;

class StringManipulationController
{
    public function index()
    {
        return View::make('string-manipulation');
    }

    public function eval(string $target, string $operation)
    {
        $result = app(StringUtility::class, [$target])->{$operation}();

        Request::flash();

        return View::make('string-manipulation', ['result' => $result]);
    }
}
