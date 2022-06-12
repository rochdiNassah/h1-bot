<?php declare(strict_types=1);

namespace Automation\Core\Http;

use Automation\Core\Application;
use Automation\Interfaces\RequestInterface;

class Request implements RequestInterface
{
    public function foo()
    {
        dump(__FUNCTION__);
    }
}