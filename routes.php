<?php declare(strict_types=1);

use Automation\Core\Facades\Router;
use Automation\App\Controllers\StringController;
use Automation\Core\Utilities\StringUtility;
use Automation\Core\Facades\View;

Router::get('string', [StringController::class, 'index']);

Router::post('/string', function (string $target, string $operation) {
    $length = app(StringUtility::class, [$target])->{$operation}();

    return View::make('string', ['result' => $length]);
});