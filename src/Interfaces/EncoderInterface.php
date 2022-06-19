<?php declare(strict_types=1);

namespace Automation\Interfaces;

interface EncoderInterface
{
    public function encode(string $string, string $as): string;

    public function decode(string $string, string $as): string;

    public function detect(string $string): string;
}