<?php

namespace Tests\Unit\Services\Keys;

use WPHeadless\Auth\Services\Keys;

class KeysServiceTest extends \Tests\TestCase
{
    public function test_it_can_return_the_key_paths()
    {
        $path = WPH_AUTH_PLUGIN_PATH;

        $this->assertEquals(Keys::keyPath('private'), "$path/oauth-private.key");

        $this->assertEquals(Keys::keyPath('public'), "$path/oauth-public.key");
    }
}
