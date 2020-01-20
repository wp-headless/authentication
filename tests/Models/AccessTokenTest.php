<?php

namespace Tests\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use WPHeadless\JWTAuth\Services\Database;
use WPHeadless\JWTAuth\Models\AccessToken;

class AccessTokenTest extends \Tests\TestCase
{
    public function setUp()
    {
        parent::setUp();

        (new Database)->install();
    }

    public function tearDown()
    {
        parent::tearDown();

        (new Database)->uninstall();
    }

    public function test_it_can_persist_to_the_db()
    {
        global $wpdb; 

        $table = Database::getTokenTable();

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
            'user_id' => 123,
            'revoked' => 0,
            'created_at' => $dateTime->toDateTimeString(),
            'updated_at' => null,
            'expires_at' => $dateTime->toDateTimeString(),
        ]);

        $numRows = $wpdb->get_var("SELECT COUNT(*) FROM $table");

        $this->assertEquals($numRows, 1);        
    }
}
