<?php

namespace App\Composer;

use Composer\Script\Event;

class Console
{
    public static function makeEntity(Event $event): int
    {
        $args = implode(' ', array_map('escapeshellarg', $event->getArguments()));
        passthru(escapeshellarg(PHP_BINARY).' bin/console make:entity '.$args, $code);

        return $code;
    }
}

