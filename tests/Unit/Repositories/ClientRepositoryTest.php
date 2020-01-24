<?php

namespace Tests\Unit\Repositories;

use WPHeadless\Auth\Repositories\ClientRepository;
use WPHeadless\Auth\Services\PasswordClient;

class ClientRepositoryTest extends \Tests\TestCase
{
    public function test_it_returns_a_client_entity()
    {
        $repository = new ClientRepository;

        $client = $repository->getClientEntity('123');

        $this->assertEquals($client->getIdentifier(), '123');
    }

    public function test_it_returns_false_on_invalid_clients()
    {
        $repository = new ClientRepository;

        $isValid = $repository->validateClient('123', 'secret-sauce', '');

        $this->assertFalse($isValid);
    }    

    public function test_it_returns_true_on_valid_clients()
    {
        $passwordClient = new PasswordClient;

        $passwordClient->createSecret();

        $secret = $passwordClient->getSecret();

        $repository = new ClientRepository;

        $isValid = $repository->validateClient('123', $secret, '');

        $this->assertTrue($isValid);
    }        
}
