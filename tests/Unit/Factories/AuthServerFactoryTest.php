<?php

namespace Tests\Unit\Factories;

use Tests\ResetsPlugin;
use League\OAuth2\Server\AuthorizationServer;
use WPHeadless\Auth\Factories\AuthServer;

class AuthServerFactory extends \Tests\TestCase
{
    use ResetsPlugin;

    public function test_it_returns_an_auth_server_instance()
    {
        $factory = new AuthServer;

        $server = $factory->create();

        $this->assertInstanceOf(AuthorizationServer::class, $server);
    }
}
