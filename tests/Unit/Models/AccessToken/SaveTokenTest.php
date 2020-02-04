<?php

namespace Tests\Unit\Models\AccessToken;

use Carbon\CarbonImmutable;
use WPHeadless\Auth\Services\Database;
use WPHeadless\Auth\Models\AccessToken;

class SaveTokenTest extends \Tests\TestCase
{
    public function test_it_can_persist_to_the_db()
    {
        global $wpdb; 

        $table = Database::getAccessTokenTable();

        $numRows = $wpdb->get_var("SELECT COUNT(*) FROM $table");

        $this->assertEquals($numRows, 0);

        $dateTime = CarbonImmutable::now()->setMicroSeconds(0);

        $token = new AccessToken;

        $token->setIdentifier('mock-token-id');

        $token->setExpiryDateTime($dateTime);

        $token->setUserIdentifier(123);

        $token->save();

        $row = (array) $wpdb->get_row("SELECT * FROM $table WHERE id = 'mock-token-id'");

        $this->assertEquals($row, [
            'id' => 'mock-token-id',
            'user_id' => "123",
            'created_at' => $dateTime->toDateTimeString(),
            'expires_at' => $dateTime->toDateTimeString(),
            'revoked_at' => null,
        ]);

        $numRows = $wpdb->get_var("SELECT COUNT(*) FROM $table");

        $this->assertEquals($numRows, 1);        
    }
}
