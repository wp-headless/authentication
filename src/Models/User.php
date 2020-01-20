<?php

namespace WPHeadless\JWTAuth\Models;

use WP_User;
use League\OAuth2\Server\Entities\UserEntityInterface;

class User implements UserEntityInterface
{
    /**
     * @var WP_User
     */
    protected $user;

    public function __construct(WP_User $user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        return $this->user->ID;
    }
}
