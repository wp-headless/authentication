<?php

namespace Tests\Unit\Plugin;

use Mockery;
use WPHeadless\Auth\Plugin;
use WPHeadless\Auth\Services\Keys;
use WPHeadless\Auth\Services\Database;
use WPHeadless\Auth\Services\PasswordClient;

class DeactivtionTest extends \Tests\TestCase
{
    public function test_it_destroys_keys_on_deactivation()
    {
        $keys = Mockery::mock(Keys::class)
            ->shouldReceive('destroy')
            ->once()
            ->getMock();

        $database = Mockery::mock(Database::class)
            ->shouldIgnoreMissing();

        $passwordClient = Mockery::mock(PasswordClient::class)
            ->shouldIgnoreMissing();

        $plugin = new Plugin($keys, $database, $passwordClient);

        $plugin->deactivate();

        $this->assertTrue(true); // null mockery assertion
    }

    public function test_it_uninstalls_tables_on_deactivation()
    {
        $keys = Mockery::mock(Keys::class)
            ->shouldIgnoreMissing();

        $database = Mockery::mock(Database::class)
            ->shouldReceive('uninstall')
            ->once()
            ->getMock();

        $passwordClient = Mockery::mock(PasswordClient::class)
            ->shouldIgnoreMissing();

        $plugin = new Plugin($keys, $database, $passwordClient);

        $plugin->deactivate();

        $this->assertTrue(true); // null mockery assertion
    }

    public function test_it_destroys_password_grant_client_secret_on_deactivation()
    {
        $keys = Mockery::mock(Keys::class)
            ->shouldIgnoreMissing();

        $database = Mockery::mock(Database::class)
            ->shouldIgnoreMissing();

        $passwordClient = Mockery::mock(PasswordClient::class)
            ->shouldReceive('destroySecret')
            ->once()
            ->getMock();

        $plugin = new Plugin($keys, $database, $passwordClient);

        $plugin->deactivate();

        $this->assertTrue(true); // null mockery assertion
    }
}
