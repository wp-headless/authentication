<?php

namespace Tests\Unit;

use DateInterval;
use Carbon\Carbon;
use WPHeadless\Auth\Auth;
use Tests\ResetsPlugin;
use Tests\Fixtures;
class AuthTest extends \Tests\TestCase
{
    use ResetsPlugin;

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
    
    public function test_it_can_decode_a_token()
    {
        $userId = Fixtures\Users::create([
            'user_login' => 'test.user',
            'user_email' => 'test.user@wp.org',
            'user_pass' => 'secret'
        ]);

        $jwt = Fixtures\Requests::accessToken('test.user', 'secret')
            ->get_data()
            ->access_token;

        $decoded = Auth::decode($jwt);

        $this->assertEquals($decoded['sub'], $userId);
        $this->assertEquals($decoded['aud'], '');
        $this->assertEquals($decoded['scopes'], []);

        $this->assertTrue(
            Carbon::createFromTimestamp($decoded['exp'])->gte(Carbon::now())
        );     
    }
}
