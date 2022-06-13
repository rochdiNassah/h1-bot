<?php declare(strict_types=1);

namespace Automation\Core\Http;

use Automation\Core\Application;
use Automation\Interfaces\RequestInterface;
use Automation\Core\Http\Bags\ServerBag;

class Request implements RequestInterface
{
    public function __construct(
        private Application $app,
        private ServerBag $server
    ) {

    }

    public function foo()
    {
        dump($this->server->all());
    }
}