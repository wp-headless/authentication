<?php

namespace Tests\Unit\Models\RefreshToken;

use WPHeadless\Auth\Models\RefreshToken;
use Tests\Fixtures;

class RevokedTest extends \Tests\TestCase
{
    public function test_it_can_revoke_itself()
    {
        Fixtures\RefreshToken::create([
            'id' => 'refresh-token-id',
        ]);

        $token = RefreshToken::getById('refresh-token-id');

        $this->assertFalse($token->isRevoked());

        $token->revoke();

        $token = RefreshToken::getById('refresh-token-id');

        $this->assertTrue($token->isRevoked());
    }
}
