<?php

namespace Tests\Unit\Models\RefreshToken;

use Carbon\Carbon;
use Tests\Fixtures;

class UpdateTokenTest extends \Tests\TestCase
{
    public function test_it_can_update_attributes_of_a_token()
    {
        $token = Fixtures\RefreshToken::create();         

        $this->assertNotEquals($token->access_token_id, 'mock-access-token-id');
        $this->assertNotEquals($token->created_at, '2021-09-28 11:00:00');
        $this->assertNotEquals($token->expires_at, '2022-09-28 11:00:00');
        $this->assertNotEquals($token->revoked_at, '2021-09-28 12:00:00');

        $token->update([
            'access_token_id' => 'mock-access-token-id',
            'created_at' => '2021-09-28 11:00:00',
            'expires_at' => '2022-09-28 11:00:00',
            'revoked_at' => '2021-09-28 12:00:00',
        ]);

        $token = $token->fresh();   

        $this->assertEquals($token->access_token_id, 'mock-access-token-id');
        $this->assertEquals($token->created_at, '2021-09-28 11:00:00');
        $this->assertEquals($token->expires_at, '2022-09-28 11:00:00');
        $this->assertEquals($token->revoked_at, '2021-09-28 12:00:00');        
    }

    public function test_it_accepts_carbon_instances()
    {
        $token = Fixtures\RefreshToken::create();         

        $this->assertNotEquals($token->access_token_id, 'mock-access-token-id');
        $this->assertNotEquals($token->created_at, '2021-09-28 11:00:00');
        $this->assertNotEquals($token->expires_at, '2022-09-28 11:00:00');
        $this->assertNotEquals($token->revoked_at, '2021-09-28 12:00:00');

        $token->update([
            'access_token_id' => 'mock-access-token-id',
            'created_at' => Carbon::parse('2021-09-28 11:00:00'),
            'expires_at' => Carbon::parse('2022-09-28 11:00:00'),
            'revoked_at' => Carbon::parse('2021-09-28 12:00:00'),
        ]);

        $token = $token->fresh();   

        $this->assertEquals($token->access_token_id, 'mock-access-token-id');
        $this->assertEquals($token->created_at, '2021-09-28 11:00:00');
        $this->assertEquals($token->expires_at, '2022-09-28 11:00:00');
        $this->assertEquals($token->revoked_at, '2021-09-28 12:00:00');        
    }    
}
