<?php declare(strict_types=1);

namespace Automation\Framework\Encoding;

interface EncoderInterface
{
    public function encode(string $string, string $as): string;

    public function decode(string $string, string $as): string;

    public function detect(string $string): string|false;

    public function supportedTypes(): array;
}