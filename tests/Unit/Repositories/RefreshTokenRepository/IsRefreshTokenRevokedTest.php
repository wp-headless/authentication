<?php

namespace Tests\Unit\Repositories\RefreshTokenRepository;

use Carbon\Carbon;
use Tests\Fixtures;
use Tests\RefreshesDatabase;
use WPHeadless\Auth\Repositories\RefreshTokenRepository;

class IsRefreshTokenRevokedTest extends \Tests\TestCase
{
    use RefreshesDatabase;

    public function test_it_can_check_non_revoked_token()
    {
        Fixtures\RefreshToken::create([
            'id' => 'mock-token-id',
            'revoked_at' => null,
        ]);

        $repository = new RefreshTokenRepository;

        $this->assertFalse(
            $repository->isRefreshTokenRevoked('mock-token-id')
        );
    }

    public function test_it_can_check_revoked_token()
    {
        Fixtures\RefreshToken::create([
            'id' => 'mock-token-id',
            'revoked_at' => Carbon::now()->toDateTimeString(),
        ]);

        $repository = new RefreshTokenRepository;

        $this->assertTrue(
            $repository->isRefreshTokenRevoked('mock-token-id')
        );
    }    
}
