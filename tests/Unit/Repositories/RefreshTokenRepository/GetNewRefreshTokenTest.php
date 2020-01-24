<?php

namespace Tests\Unit\Repositories\RefreshTokenRepository;

use Mockery;
use WPHeadless\Auth\Models\RefreshToken;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use WPHeadless\Auth\Repositories\RefreshTokenRepository;

class GetNewRefreshTokenTest extends \Tests\TestCase
{
    public function test_it_returns_new_access_token()
    {
        $repository = new RefreshTokenRepository;

        $token = $repository->getNewRefreshToken();

        $this->assertInstanceOf(RefreshToken::class, $token);
    }
}
