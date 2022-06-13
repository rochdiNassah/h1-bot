<?php declare(strict_types=1);

require '../vendor/autoload.php';

use Automation\Core\Facades\{Request, Filesystem};

$app = Automation\Core\Application::instance();

$app->run();

$data = json_decode('{"iss": "portswigger","exp": 1648037164,"name": "Carlos Montoya","sub": "carlos","role": "blog_author","email": "carlos@carlos-montoya.net","iat": 1516239022}');

dump($data);