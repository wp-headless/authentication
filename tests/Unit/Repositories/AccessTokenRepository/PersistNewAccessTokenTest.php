<?php

namespace Tests\Unit\Repositories\AccessTokenRepository;

use Mockery;
use WPHeadless\Auth\Models\AccessToken;
use WPHeadless\Auth\Repositories\AccessTokenRepository;

class PersistNewAccessTokenTest extends \Tests\TestCase
{
    public function test_it_persists_access_tokens()
    {
        // see  \Tests\Models\AccessTokenTest

        $token = Mockery::mock(AccessToken::class)
            ->shouldReceive('save')
            ->once()
            ->withNoArgs()
            ->getMock();

        $repository = new AccessTokenRepository;

        $this->assertNull(
            $repository->persistNewAccessToken($token)
        );
    }
}
