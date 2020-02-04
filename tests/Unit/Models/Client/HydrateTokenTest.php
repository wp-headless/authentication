<?php

namespace Tests\Unit\Models\Client;

use Carbon\Carbon;
use WPHeadless\Auth\Models\Client;

class HydrateTokenTest extends \Tests\TestCase
{
    public function test_it_returns_a_client_model()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = Client::hydrate([
            'id' => 'mock-client-id',
            'user_id' => 123,
            'name' => 'foo-bar',
            'secret' => '0123456789',
            'redirect' => 'https://google.com/',
            'personal_access_client' => 0,
            'password_client' => 1,
            'created_at' => $now->toDateTimeString(),
            'revoked_at' => null,
        ]);

        $this->assertInstanceOf(Client::class, $token);
    }

    public function test_it_hydrates_properties()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = Client::hydrate([
            'id' => 'mock-client-id',
            'user_id' => 123,
            'name' => 'foo-bar',
            'secret' => '0123456789',
            'redirect' => 'https://google.com/',
            'personal_access_client' => 0,
            'password_client' => 1,
            'created_at' => $now->toDateTimeString(),
            'revoked_at' => $now->toDateTimeString(),
        ]);

        $this->assertEquals($token->id, "mock-client-id");

        $this->assertEquals($token->user_id, 123);

        $this->assertEquals($token->getName(), "foo-bar");

        $this->assertEquals($token->secret, "0123456789");

        $this->assertEquals($token->redirect, "https://google.com/");

        $this->assertEquals($token->personal_access_client, 0);

        $this->assertEquals($token->password_client, 1);

        $this->assertEquals($token->created_at, $now);

        $this->assertEquals($token->revoked_at, $now);
    }

    public function test_it_sets_properties()
    {
        $now = Carbon::now()->setMicroseconds(0);

        $token = Client::hydrate([
            'id' => 'mock-client-id',
            'user_id' => 123,
            'name' => 'foo-bar',
            'secret' => '0123456789',
            'redirect' => 'https://google.com/',
            'personal_access_client' => 0,
            'password_client' => 1,
            'created_at' => $now->toDateTimeString(),
            'revoked_at' => $now->toDateTimeString(),
        ]);

        $this->assertEquals($token->getIdentifier(), 'mock-client-id');

        $this->assertEquals($token->getName(), 'foo-bar');

        $this->assertEquals($token->getRedirectUri(), 'https://google.com/');
    }
}
