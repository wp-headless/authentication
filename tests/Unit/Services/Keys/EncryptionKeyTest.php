<?php

namespace Tests\Unit\Services\Keys;

use WPHeadless\Auth\Services\Keys;

class EncryptionKeyTest extends \Tests\TestCase
{
    public function test_it_gets_and_sets_encryption_key()
    {
        $service = new Keys;

        $this->assertEquals(Keys::getEncryptionKey(), '');

        $service->generate();

        $this->assertTrue(strlen(Keys::getEncryptionKey()) > 40);

        $service->destroy();
    }

    public function test_it_destroys_encryption_key()
    {
        $service = new Keys;

        $service->generate();

        $this->assertTrue(strlen(Keys::getEncryptionKey()) > 1);

        $service->destroy();

        $this->assertEquals(Keys::getEncryptionKey(), '');
    }    
}
