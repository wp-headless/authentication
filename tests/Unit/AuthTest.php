<?php

namespace Tests\Unit;

use DateInterval;
use WPHeadless\Auth\Auth;

class AuthTest extends \Tests\TestCase
{
    public function test_it_has_default_refresh_token_expiration()
    {
        $interval = Auth::refreshTokensExpireIn();

        $this->assertEquals($interval, new DateInterval('P1Y'));
    }

    public function test_it_can_set_refresh_token_expiration()
    {
        define('OAUTH_REFRESH_TOKEN_EXPIRES', 'P2Y');

        $interval = Auth::refreshTokensExpireIn();

        $this->assertEquals($interval, new DateInterval('P2Y'));
    }   
    
    public function test_it_has_default_access_token_expiration()
    {
        $interval = Auth::accessTokensExpireIn();

        $this->assertEquals($interval, new DateInterval('P1Y'));
    }

    public function test_it_can_set_access_token_expiration()
    {
        define('OAUTH_ACCESS_TOKEN_EXPIRES', 'P2Y');

        $interval = Auth::accessTokensExpireIn();

        $this->assertEquals($interval, new DateInterval('P2Y'));
    }        
}
