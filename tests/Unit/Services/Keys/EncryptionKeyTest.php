<?php

namespace Tests\Unit\Services\Keys;

use Tests\ResetsPlugin;
use WPHeadless\Auth\Services\Keys;

class EncryptionKeyTest extends \Tests\TestCase
{
    use ResetsPlugin;

    public function test_it_gets_and_sets_encryption_key()
    {
        $service = new Keys;

        $service->destroy(); // destroy current

        $this->assertTrue(strlen(Keys::getEncryptionKey()) === 0);

        $service->generate();

        $this->assertTrue(strlen(Keys::getEncryptionKey()) > 40);
    }

    public function test_it_destroys_encryption_key()
    {
        $service = new Keys;

        $this->assertTrue(strlen(Keys::getEncryptionKey()) > 1);

        $service->destroy();

        $this->assertEquals(Keys::getEncryptionKey(), '');
    }    
}
