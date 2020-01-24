<?php

namespace Tests\Unit\Repositories\RefreshTokenRepository;

use Mockery;
use WPHeadless\Auth\Models\RefreshToken;
use WPHeadless\Auth\Repositories\RefreshTokenRepository;

class PersistNewRefreshTokenTest extends \Tests\TestCase
{
    public function test_it_persists_refresh_tokens()
    {
        // see  \Tests\Models\RefreshToken

        $token = Mockery::mock(RefreshToken::class)
            ->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->getMock();

        $repository = new RefreshTokenRepository;

        $this->assertNull(
            $repository->persistNewRefreshToken($token)
        );
    }
}
