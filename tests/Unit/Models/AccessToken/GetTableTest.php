<?php

namespace Tests\Unit\Models\AccessToken;

use WPHeadless\Auth\Models\AccessToken;

class GetTableTest extends \Tests\TestCase
{
    public function test_it_returns_correct_table()
    {
        $this->assertEquals(AccessToken::getTable(), 'wp_oauth_access_tokens');
    }
}
