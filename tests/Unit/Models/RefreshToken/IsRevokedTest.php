<?php

namespace Tests\Unit\Models\RefreshToken;

use Carbon\Carbon;
use Tests\RefreshesDatabase;
use WPHeadless\Auth\Models\RefreshToken;

class IsRevokedTest extends \Tests\TestCase
{
    use RefreshesDatabase;
    
    public function test_it_returns_true_if_revoked()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = RefreshToken::hydrate([
            'id' => 'refresh-token-id',
            'access_token_id' => 'access-token-id',
            'expires_at' => $now->toDateTimeString(),
            'revoked_at' => $now->toDateTimeString(),
        ]);

        $this->assertTrue($token->isRevoked());
    }

    public function test_it_returns_false_if_not_revoked()
    {
        $now = Carbon::now()->setMicroseconds(0);
        
        $token = RefreshToken::hydrate([
            'id' => 'refresh-token-id',
            'access_token_id' => 'access-token-id',
            'expires_at' => $now->toDateTimeString(),
        ]);

        $this->assertFalse($token->isRevoked());
    }    
}
