<?php

namespace Tests\Unit\Repositories\AccessTokenRepository;

use Tests\Fixtures;
use Tests\RefreshesDatabase;
use WPHeadless\Auth\Models\AccessToken;
use WPHeadless\Auth\Repositories\AccessTokenRepository;

class RevokeAccessTokenTest extends \Tests\TestCase
{
    use RefreshesDatabase;

    public function test_it_can_revoke_tokens()
    {
        Fixtures\AccessToken::create([
            'id' => 'mock-token-id',
            'revoked_at' => null,
        ]);

        $repository = new AccessTokenRepository;

        $token = AccessToken::getById('mock-token-id');

        $this->assertFalse($token->isRevoked());

        $repository->revokeAccessToken('mock-token-id');

        $token = AccessToken::getById('mock-token-id');

        $this->assertTrue($token->isRevoked());        
    }

    public function test_it_only_revokes_existing_tokens()
    {
        Fixtures\AccessToken::create([
            'id' => 'mock-token-id',
            'revoked_at' => null,
        ]);

        $repository = new AccessTokenRepository;

        $token = AccessToken::getById('mock-token-id');

        $this->assertFalse($token->isRevoked());

        $repository->revokeAccessToken('does-not-exist');

        $token = AccessToken::getById('mock-token-id');

        $this->assertFalse($token->isRevoked());       
    }    
}
