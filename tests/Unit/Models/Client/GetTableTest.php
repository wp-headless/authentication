<?php

namespace Tests\Unit\Models\Client;

use WPHeadless\Auth\Models\Client;

class GetTableTest extends \Tests\TestCase
{
    public function test_it_returns_correct_table()
    {
        $this->assertEquals(Client::getTable(), 'wp_oauth_clients');
    }
}
