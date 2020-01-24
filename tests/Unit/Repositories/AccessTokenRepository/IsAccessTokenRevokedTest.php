<?php

namespace Tests\Unit\Repositories\AccessTokenRepository;

use Carbon\Carbon;
use Tests\Fixtures;
use Tests\RefreshesDatabase;
use WPHeadless\Auth\Repositories\AccessTokenRepository;

class IsAccessTokenRevokedTest extends \Tests\TestCase
{
    use RefreshesDatabase;

    public function test_it_can_check_non_revoked_token()
    {
        Fixtures\AccessToken::create([
            'id' => 'mock-token-id',
            'revoked_at' => null,
        ]);

        $repository = new AccessTokenRepository;

        $this->assertFalse(
            $repository->isAccessTokenRevoked('mock-token-id')
        );
    }

    public function test_it_can_check_revoked_token()
    {
        Fixtures\AccessToken::create([
            'id' => 'mock-token-id',
            'revoked_at' => Carbon::now()->toDateTimeString(),
        ]);

        $repository = new AccessTokenRepository;

        $this->assertTrue(
            $repository->isAccessTokenRevoked('mock-token-id')
        );
    }    
}
