<?php declare(strict_types=1);

use Automation\Core\Facades\Console;
use Automation\App\Commands\Encoding\{EncodeCommand, DecodeCommand, DetectEncodingCommand, SplitJWTCommand};
use Automation\App\Commands\Misc\StrlenCommand;

Console::add(app(EncodeCommand::class));
Console::add(app(DecodeCommand::class));
Console::add(app(DetectEncodingCommand::class));
Console::add(app(SplitJWTCommand::class));
Console::add(app(StrlenCommand::class));