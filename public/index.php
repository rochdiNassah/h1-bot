<?php declare(strict_types=1);

require '../vendor/autoload.php';

use Automation\Core\Facades\{Request, Filesystem, Router};

$app = Automation\Core\Application::instance();

$app->run();

Router::get('/person/{name}/{ag+e}/name', function (): string {
    return 'foo';
});