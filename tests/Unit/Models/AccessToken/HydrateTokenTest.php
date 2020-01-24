<?php

namespace Tests\Unit\Models\AccessToken;

use Carbon\Carbon;
use WPHeadless\Auth\Models\AccessToken;

class HydrateTokenTest extends \Tests\TestCase
{
    public function test_it_returns_a_token_model()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = AccessToken::hydrate([
            'id' => 'mock-token-id',
            'user_id' => 123,
            'created_at' => $now->toDateTimeString(),
            'expires_at' => $now->toDateTimeString(),
        ]);

        $this->assertInstanceOf(AccessToken::class, $token);
    }

    public function test_it_hydrates_properties()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = AccessToken::hydrate([
            'id' => 'mock-token-id',
            'user_id' => 123,
            'created_at' => $now->toDateTimeString(),
            'expires_at' => $now->toDateTimeString(),
            'revoked_at' => $now->toDateTimeString(),
        ]);

        $this->assertEquals($token->user_id, "123");

        $this->assertEquals($token->created_at, $now);

        $this->assertEquals($token->expires_at, $now);

        $this->assertEquals($token->revoked_at, $now);
    }

    public function test_it_sets_properties()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = AccessToken::hydrate([
            'id' => 'mock-token-id',
            'user_id' => 123,
            'created_at' => $now->toDateTimeString(),
            'expires_at' => $now->toDateTimeString(),
        ]);

        $this->assertEquals($token->getIdentifier(), 'mock-token-id');

        $this->assertEquals($token->getUserIdentifier(), 123);

        $this->assertEquals($token->getExpiryDateTime(), $now);
    }
}
