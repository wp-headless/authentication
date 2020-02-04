<?php

namespace Tests\Unit\Models\AccessToken;

use Carbon\Carbon;
use Tests\Fixtures;

class UpdateTokenTest extends \Tests\TestCase
{
    public function test_it_can_update_attributes_of_a_token()
    {
        $token = Fixtures\AccessToken::create();         

        $this->assertNotEquals($token->user_id, 101);
        $this->assertNotEquals($token->created_at, '2021-09-28 11:00:00');
        $this->assertNotEquals($token->expires_at, '2022-09-28 11:00:00');
        $this->assertNotEquals($token->revoked_at, '2021-09-28 12:00:00');

        $token->update([
            'user_id' => 101,
            'created_at' => '2021-09-28 11:00:00',
            'expires_at' => '2022-09-28 11:00:00',
            'revoked_at' => '2021-09-28 12:00:00',
        ]);

        $token = $token->fresh();   

        $this->assertEquals($token->user_id, 101);
        $this->assertEquals($token->created_at, '2021-09-28 11:00:00');
        $this->assertEquals($token->expires_at, '2022-09-28 11:00:00');
        $this->assertEquals($token->revoked_at, '2021-09-28 12:00:00');        
    }

    public function test_it_accepts_carbon_instances()
    {
        $token = Fixtures\AccessToken::create();         

        $this->assertNotEquals($token->user_id, 101);
        $this->assertNotEquals($token->created_at, '2021-09-28 11:00:00');
        $this->assertNotEquals($token->expires_at, '2022-09-28 11:00:00');
        $this->assertNotEquals($token->revoked_at, '2021-09-28 12:00:00');

        $token->update([
            'user_id' => 101,
            'created_at' => Carbon::parse('2021-09-28 11:00:00'),
            'expires_at' => Carbon::parse('2022-09-28 11:00:00'),
            'revoked_at' => Carbon::parse('2021-09-28 12:00:00'),
        ]);

        $token = $token->fresh();   

        $this->assertEquals($token->user_id, 101);
        $this->assertEquals($token->created_at, '2021-09-28 11:00:00');
        $this->assertEquals($token->expires_at, '2022-09-28 11:00:00');
        $this->assertEquals($token->revoked_at, '2021-09-28 12:00:00');        
    }    
}
