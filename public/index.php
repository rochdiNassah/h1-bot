<?php declare(strict_types=1);

require '../vendor/autoload.php';

use Automation\Framework\Facades\{Request, Filesystem, Router, Encoder};

$app = Automation\Framework\Application::instance();

$app->run();