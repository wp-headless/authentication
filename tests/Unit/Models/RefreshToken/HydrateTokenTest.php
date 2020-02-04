<?php

namespace Tests\Unit\Models\RefreshToken;

use Carbon\Carbon;
use Tests\Fixtures;
use WPHeadless\Auth\Models\RefreshToken;

class HydrateTokenTest extends \Tests\TestCase
{
    public function test_it_returns_a_token_model()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = RefreshToken::hydrate([
            'id' => 'refresh-token-id',
            'access_token_id' => 'access-token-id',
            'created_at' => $now->toDateTimeString(),
            'expires_at' => $now->toDateTimeString(),
        ]);

        $this->assertInstanceOf(RefreshToken::class, $token);
    }

    public function test_it_hydrates_properties()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = RefreshToken::hydrate([
            'id' => 'refresh-token-id',
            'access_token_id' => 'access-token-id',
            'created_at' => $now->toDateTimeString(),
            'expires_at' => $now->toDateTimeString(),
            'revoked_at' => $now->toDateTimeString(),
        ]);

        $this->assertEquals($token->access_token_id, 'access-token-id');

        $this->assertEquals($token->created_at, $now);

        $this->assertEquals($token->expires_at, $now);

        $this->assertEquals($token->revoked_at, $now);
    }

    public function test_it_sets_properties()
    {
        Fixtures\AccessToken::create([
            'id' => 'access-token-id',
        ]);
                
        $now = Carbon::now()->setMicroseconds(0);

        $token = RefreshToken::hydrate([
            'id' => 'refresh-token-id',
            'access_token_id' => 'access-token-id',
            'created_at' => $now->toDateTimeString(),
            'expires_at' => $now->toDateTimeString(),
            'revoked_at' => $now->toDateTimeString(),
        ]);

        $this->assertEquals($token->getIdentifier(), 'refresh-token-id');

        $this->assertEquals($token->getAccessToken()->getIdentifier(), 'access-token-id');

        $this->assertEquals($token->getExpiryDateTime(), $now);
    }
}
