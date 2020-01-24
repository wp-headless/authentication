<?php

namespace Tests\Unit\Plugin;

use Mockery;
use WPHeadless\Auth\Plugin;
use WPHeadless\Auth\Services\Keys;
use WPHeadless\Auth\Services\Database;
use WPHeadless\Auth\Services\PasswordClient;

class ActivtionTest extends \Tests\TestCase
{
    public function test_it_generates_keys_on_activation()
    {
        $keys = Mockery::mock(Keys::class)
            ->shouldReceive('generate')
            ->once()
            ->getMock();

        $database = Mockery::mock(Database::class)
            ->shouldIgnoreMissing();

        $passwordClient = Mockery::mock(PasswordClient::class)
            ->shouldIgnoreMissing();

        $plugin = new Plugin($keys, $database, $passwordClient);

        $plugin->activate();

        $this->assertTrue(true); // null mockery assertion
    }

    public function test_it_installs_tables_on_activation()
    {
        $keys = Mockery::mock(Keys::class)
            ->shouldIgnoreMissing();

        $database = Mockery::mock(Database::class)
            ->shouldReceive('install')
            ->once()
            ->getMock();

        $passwordClient = Mockery::mock(PasswordClient::class)
            ->shouldIgnoreMissing();

        $plugin = new Plugin($keys, $database, $passwordClient);

        $plugin->activate();

        $this->assertTrue(true); // null mockery assertion
    }

    public function test_it_creates_password_grant_client_secret()
    {
        $keys = Mockery::mock(Keys::class)
            ->shouldIgnoreMissing();

        $database = Mockery::mock(Database::class)
            ->shouldIgnoreMissing();

        $passwordClient = Mockery::mock(PasswordClient::class)
            ->shouldReceive('createSecret')
            ->once()
            ->getMock();

        $plugin = new Plugin($keys, $database, $passwordClient);

        $plugin->activate();

        $this->assertTrue(true); // null mockery assertion
    }
}
