<?php

namespace Tests\Repositories;

use Mockery;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use WPHeadless\JWTAuth\Repositories\UserRepository;

class UserRepositoryTest extends \Tests\TestCase
{
    public function test_it_can_return_user_by_username_pwd()
    {
        $userId = wp_create_user('homer_simpson', 'secret', 'homer@springfield.com');

        $repository = new UserRepository;

        $client = Mockery::mock(ClientEntityInterface::class);

        $user = $repository->getUserEntityByUserCredentials('homer_simpson', 'secret', '', $client);

        $this->assertEquals($user->getIdentifier(), $userId);
    }

    public function test_it_can_return_user_by_email_pwd()
    {
        $userId = wp_create_user('homer_simpson', 'secret', 'homer@springfield.com');

        $repository = new UserRepository;

        $client = Mockery::mock(ClientEntityInterface::class);

        $user = $repository->getUserEntityByUserCredentials('homer@springfield.com', 'secret', '', $client);

        $this->assertEquals($user->getIdentifier(), $userId);
    }    

    public function test_it_returns_null_when_no_user_found()
    {
        $repository = new UserRepository;

        $client = Mockery::mock(ClientEntityInterface::class);

        $user = $repository->getUserEntityByUserCredentials('homer_simpson', 'secret', '', $client);

        $this->assertNull($user);
    }    
}
