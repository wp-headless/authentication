<?php

namespace Tests\Unit\Models\AccessToken;

use WPHeadless\Auth\Models\AccessToken;
use Tests\Fixtures;

class GetByIdTest extends \Tests\TestCase
{
    public function test_it_can_return_token_by_id()
    {
        Fixtures\AccessToken::create([
            'id' => 'mock-token-id'
        ]);

        $token = AccessToken::getById('mock-token-id');

        $this->assertEquals($token->getIdentifier(), 'mock-token-id');

        $this->assertInstanceOf(AccessToken::class, $token);
    }
}
