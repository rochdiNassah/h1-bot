<?php declare(strict_types=1);

use Automation\Core\Facades\Console;
use Automation\App\Commands\Encoding\{EncodeCommand, DecodeCommand, DetectEncodingCommand, SplitJWTCommand};
use Automation\App\Commands\Misc\StrlenCommand;
use Automation\App\Commands\Bruteforcing\BruteforceJWTSecretKeyCommand;
use Automation\App\Commands\Alerts\MonitorPacketsCommand;

Console::add(app(EncodeCommand::class));
Console::add(app(DecodeCommand::class));
Console::add(app(DetectEncodingCommand::class));
Console::add(app(SplitJWTCommand::class));
Console::add(app(StrlenCommand::class));
console::add(app(BruteforceJWTSecretKeyCommand::class));
Console::add(app(MonitorPacketsCommand::class));