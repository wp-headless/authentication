<?php

namespace Tests\Unit\Models\RefreshToken;

use WPHeadless\Auth\Models\RefreshToken;
use Tests\Fixtures;

class GetByIdTest extends \Tests\TestCase
{
    public function test_it_can_return_token_by_id()
    {
        Fixtures\RefreshToken::create([
            'id' => 'mock-token-id'
        ]);

        $token = RefreshToken::getById('mock-token-id');

        $this->assertEquals($token->getIdentifier(), 'mock-token-id');

        $this->assertInstanceOf(RefreshToken::class, $token);
    }
}
