<?php

namespace Tests\Unit\ServerFactory;

use Tests\ActivatesPlugin;
use League\OAuth2\Server\AuthorizationServer;
use WPHeadless\Auth\ServerFactory;

class ServerFactoryTest extends \Tests\TestCase
{
    use ActivatesPlugin;

    public function test_it_returns_an_auth_server_instance()
    {
        $factory = new ServerFactory;

        $server = $factory->makeAuthorizationServer();

        $this->assertInstanceOf(AuthorizationServer::class, $server);
    }
}
