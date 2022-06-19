<?php declare(strict_types=1);

require '../vendor/autoload.php';

use Automation\Core\Facades\{Request, Filesystem};

$app = Automation\Core\Application::instance();

$app->run();

$target = '&#x66;&#x6f;&#x6f;';

dump(htmlspecialchars_decode($target));