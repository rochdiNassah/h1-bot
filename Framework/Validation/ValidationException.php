<?php declare(strict_types=1);

namespace Automation\Framework\Validation;

use Automation\Framework\Exceptions\Redirectable;
use Automation\Framework\Http\Request;

class ValidationException extends \Exception implements Redirectable
{
    private string $destination;

    public function __construct(Request $request)
    {
        $this->destination = $request->getReferer();
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function getHttpResponseCode(): int
    {
        return 301;
    }
}