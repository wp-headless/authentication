<?php

namespace Tests\Unit\Repositories;

use Mockery;
use WPHeadless\Auth\Exceptions\InvalidCredentials;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use WPHeadless\Auth\Repositories\UserRepository;

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

    public function test_it_returns_throws_when_no_user_found()
    {
        $this->expectException(InvalidCredentials::class);

        $repository = new UserRepository;

        $client = Mockery::mock(ClientEntityInterface::class);

        $repository->getUserEntityByUserCredentials('homer_simpson', 'secret', '', $client);
    }    
}
