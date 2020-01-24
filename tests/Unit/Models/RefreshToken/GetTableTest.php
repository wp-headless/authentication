<?php

namespace Tests\Unit\Models\RefreshToken;

use WPHeadless\Auth\Models\RefreshToken;

class GetTableTest extends \Tests\TestCase
{
    public function test_it_returns_correct_table()
    {
        $this->assertEquals(RefreshToken::getTable(), 'wp_oauth_refresh_tokens');
    }
}
