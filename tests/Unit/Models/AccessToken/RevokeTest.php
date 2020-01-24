<?php

namespace Tests\Unit\Models\AccessToken;

use Tests\RefreshesDatabase;
use WPHeadless\Auth\Models\AccessToken;
use Tests\Fixtures;

class RevokedTest extends \Tests\TestCase
{
    use RefreshesDatabase;

    public function test_it_can_revoke_itself()
    {
        Fixtures\AccessToken::create([
            'id' => 'mock-token-id'
        ]);

        $token = AccessToken::getById('mock-token-id');

        $this->assertFalse($token->isRevoked());

        $token->revoke();

        $token = AccessToken::getById('mock-token-id');

        $this->assertTrue($token->isRevoked());
    }
}
