<?php declare(strict_types=1);

require '../vendor/autoload.php';

use Automation\Core\Facades\{Request, Filesystem};

$app = Automation\Core\Application::instance();

$app->run();


dump((string) Filesystem::to('public/index.php'));
dump(Filesystem::to('public/index.php')->exists());