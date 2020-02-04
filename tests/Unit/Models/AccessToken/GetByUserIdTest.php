<?php

namespace Tests\Unit\Models\AccessToken;

use WPHeadless\Auth\Models\AccessToken;
use Tests\Fixtures;

class GetByUserIdTest extends \Tests\TestCase
{
    public function test_it_can_return_token_by_user_id()
    {
        $userId = Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);         

        Fixtures\AccessToken::create([
            'id' => 'mock-token-id',
            'user_id' => $userId,
        ]);

        $token = AccessToken::getByUserId($userId);

        $this->assertEquals($token->getIdentifier(), 'mock-token-id');

        $this->assertInstanceOf(AccessToken::class, $token);
    }

    public function test_it_returns_null_if_user_not_existing()
    {
        $userId = Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret',
        ]);         

        Fixtures\AccessToken::create([
            'id' => 'mock-token-id',
            'user_id' => $userId,
        ]);

        $token = AccessToken::getByUserId(1234);

        $this->assertNull($token);
    }    
}
