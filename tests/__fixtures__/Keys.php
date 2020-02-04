<?php

namespace Tests\Fixtures;

class Keys
{
    public static function get(string $type): string
    {
        $path = __DIR__ . "/keys/oauth-$type.key";

        return file_get_contents($path);
    }
}