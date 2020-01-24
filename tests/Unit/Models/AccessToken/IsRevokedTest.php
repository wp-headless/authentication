<?php

namespace Tests\Unit\Models\AccessToken;

use Carbon\Carbon;
use WPHeadless\Auth\Models\AccessToken;

class IsRevokedTest extends \Tests\TestCase
{
    public function test_it_returns_true_if_revoked()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = AccessToken::hydrate([
            'id' => 'mock-token-id',
            'user_id' => 123,
            'expires_at' => $now->toDateTimeString(),
            'revoked_at' => $now->toDateTimeString(),
        ]);

        $this->assertTrue($token->isRevoked());
    }

    public function test_it_returns_false_if_not_revoked()
    {
        $now = Carbon::now()->setMicroseconds(0);
        
        $token = AccessToken::hydrate([
            'id' => 'mock-token-id',
            'user_id' => 123,
            'expires_at' => $now->toDateTimeString(),
        ]);

        $this->assertFalse($token->isRevoked());
    }    
}
