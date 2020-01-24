<?php

namespace Tests\Unit\Repositories;

use Mockery;
use WPHeadless\Auth\Models\Client;
use WPHeadless\Auth\Repositories\ScopeRepository;

class ScopeRepositoryTest extends \Tests\TestCase
{
    public function test_there_are_no_scopes()
    {
        $repository = new ScopeRepository;

        $this->assertNull(
            $repository->getScopeEntityByIdentifier('')
        );

        $client = Mockery::mock(Client::class);

        $this->assertEquals($repository->finalizeScopes([], '', $client), []);        
    }     
}
