<?php

namespace Tests\Fixtures;

use Carbon\Carbon;
use WPHeadless\Auth\Services\Database;

class RefreshToken
{
    public static function create(array $attributes = []): void
    {
        global $wpdb; 

        $table = Database::getRefreshTokenTable();
    
        $format = ['%s','%d','%s','%s'];

        $dateTime = Carbon::now()->toDateTimeString();

        $data = array_merge([
            'id' => (string) rand(1,100),
            'access_token_id' => 123,
            'created_at' => $dateTime,
            'expires_at' => $dateTime,            
        ], $attributes);

        $wpdb->insert($table, $data, $format);           
    }
}