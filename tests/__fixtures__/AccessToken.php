<?php

namespace Tests\Fixtures;

use Carbon\Carbon;
use WPHeadless\Auth\Services\Database;
use WPHeadless\Auth\Models\AccessToken as Token;

class AccessToken
{
    public static function create(array $attributes = []): Token
    {
        global $wpdb; 

        $table = Database::getAccessTokenTable();
    
        $format = ['%s','%d','%s','%s'];

        $dateTime = Carbon::now()->toDateTimeString();

        $data = array_merge([
            'id' => (string) rand(1,100),
            'user_id' => 123,
            'created_at' => $dateTime,
            'expires_at' => $dateTime,            
        ], $attributes);

        $wpdb->insert($table, $data, $format);    
        
        return Token::getById($data['id']);
    }
}