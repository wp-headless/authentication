<?php

namespace Tests\Unit\Models;

use WPHeadless\Auth\Models\User;

class UserTest extends \Tests\TestCase
{
    public function test_it_can_return_user_id()
    {
        $userId = wp_create_user('homer_simpson', 'secret', 'homer@springfield.com');

        $wpUser = get_user_by('id', $userId);

        $user = new User($wpUser);

        $this->assertEquals($user->getIdentifier(), $wpUser->ID);
    }
}
