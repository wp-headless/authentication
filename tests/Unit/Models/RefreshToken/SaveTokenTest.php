<?php

namespace Tests\Unit\Models\RefreshToken;

use Carbon\CarbonImmutable;
use WPHeadless\Auth\Services\Database;
use WPHeadless\Auth\Models\RefreshToken;
use WPHeadless\Auth\Models\AccessToken;

class SaveTokenTest extends \Tests\TestCase
{
    public function test_it_can_persist_to_the_db()
    {
        global $wpdb; 

        $table = Database::getRefreshTokenTable();

        $numRows = $wpdb->get_var("SELECT COUNT(*) FROM $table");

        $this->assertEquals($numRows, 0);

        $dateTime = CarbonImmutable::now()->setMicroSeconds(0);

        $accessToken = new AccessToken;

        $accessToken->setIdentifier('access-token-id');

        $refreshToken = new RefreshToken;

        $refreshToken->setIdentifier('refresh-token-id');

        $refreshToken->setAccessToken($accessToken);

        $refreshToken->setExpiryDateTime($dateTime);

        $refreshToken->save();

        $row = (array) $wpdb->get_row("SELECT * FROM $table WHERE id = 'refresh-token-id'");

        $this->assertEquals($row, [
            'id' => 'refresh-token-id',
            'access_token_id' => "access-token-id",
            'created_at' => $dateTime->toDateTimeString(),
            'expires_at' => $dateTime->toDateTimeString(),
            'revoked_at' => null,
        ]);

        $numRows = $wpdb->get_var("SELECT COUNT(*) FROM $table");

        $this->assertEquals($numRows, 1);        
    }
}
