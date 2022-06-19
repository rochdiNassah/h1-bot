<?php declare(strict_types=1);

namespace Automation\Core;

use Automation\Interfaces\EncoderInterface;

class Encoder implements EncoderInterface
{
    public function __construct(
        private Application $app
    ) {
        
    }

    public function encode(string $string, string $as): string
    {
        return '';
    }

    public function decode(string $string, string $as): string
    {
        return '';
    }

    public function detect(string $string): string
    {
        return '';
    }
}