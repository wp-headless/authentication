<?php

namespace Tests\Unit\Repositories\AccessTokenRepository;

use Mockery;
use WPHeadless\Auth\Models\AccessToken;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use WPHeadless\Auth\Repositories\AccessTokenRepository;

class GetNewTokenTest extends \Tests\TestCase
{
    public function test_it_returns_new_access_token()
    {
        $client = Mockery::mock(ClientEntityInterface::class);

        $repository = new AccessTokenRepository;

        $token = $repository->getNewToken($client, []);

        $this->assertInstanceOf(AccessToken::class, $token);
    }

    public function test_token_has_user_id()
    {
        $client = Mockery::mock(ClientEntityInterface::class);

        $repository = new AccessTokenRepository;

        $token = $repository->getNewToken($client, [], 123);

        $this->assertEquals($token->getUserIdentifier(), 123);
    }  
    
    public function test_token_has_client()
    {
        $client = Mockery::mock(ClientEntityInterface::class);

        $repository = new AccessTokenRepository;

        $token = $repository->getNewToken($client, [], 123);

        $this->assertEquals($token->getClient(), $client );
    }      
}
