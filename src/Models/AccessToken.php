<?php

namespace WPHeadless\JWTAuth\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use WPHeadless\JWTAuth\Services\Database;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

class AccessToken implements AccessTokenEntityInterface
{
    use AccessTokenTrait, EntityTrait, TokenEntityTrait;

    public function save(): void
    {
        global $wpdb;

        if ($this->identifier) {    
    
            $table = Database::getTokenTable();
    
            $format = ['%s','%d','%d','%s','%s'];
    
            $wpdb->insert($table, [
                'id' => $this->identifier,
                'user_id' => $this->userIdentifier,
                'revoked' => 0,
                'created_at' => Carbon::now()->toDateTimeString(),
                'expires_at' => Carbon::instance($this->expiryDateTime)->toDateTimeString(),
            ], $format);            
        }
    }
}
