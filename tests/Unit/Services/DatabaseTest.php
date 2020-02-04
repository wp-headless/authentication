<?php

namespace Tests\Unit\Services;

use WPHeadless\Auth\Services\Database;

class DatabaseTest extends \Tests\TestCase
{
    public function test_can_check_for_tables_existence()
    {
        $this->assertTrue(Database::tableExists('wp_posts'));

        $this->assertFalse(Database::tableExists('wp_foo'));
    }

    public function test_can_return_table_names()
    {
        $this->assertEquals(Database::getTables(), [
            'wp_oauth_access_tokens',
            'wp_oauth_refresh_tokens',
            'wp_oauth_clients',
        ]);
    }   
}
