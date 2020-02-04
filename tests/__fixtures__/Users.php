<?php

namespace Tests\Fixtures;

class Users
{
    public static function create(array $attributes = []): int
    {
        return wp_insert_user($attributes);   
    }
}