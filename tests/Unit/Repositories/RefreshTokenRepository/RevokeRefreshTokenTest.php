<?php

namespace Tests\Unit\Repositories\RefreshTokenRepository;

use Tests\Fixtures;
use WPHeadless\Auth\Models\RefreshToken;
use WPHeadless\Auth\Repositories\RefreshTokenRepository;

class RevokeRefreshTokenTest extends \Tests\TestCase
{
    public function test_it_can_revoke_tokens()
    {
        Fixtures\RefreshToken::create([
            'id' => 'mock-token-id',
            'revoked_at' => null,
        ]);

        $repository = new RefreshTokenRepository;

        $token = RefreshToken::getById('mock-token-id');

        $this->assertFalse($token->isRevoked());

        $repository->revokeRefreshToken('mock-token-id');

        $token = RefreshToken::getById('mock-token-id');

        $this->assertTrue($token->isRevoked());        
    }

    public function test_it_only_revokes_existing_tokens()
    {
        Fixtures\RefreshToken::create([
            'id' => 'mock-token-id',
            'revoked_at' => null,
        ]);

        $repository = new RefreshTokenRepository;

        $token = RefreshToken::getById('mock-token-id');

        $this->assertFalse($token->isRevoked());

        $repository->revokeRefreshToken('does-not-exist');

        $token = RefreshToken::getById('mock-token-id');

        $this->assertFalse($token->isRevoked());       
    }    
}
