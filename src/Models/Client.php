<?php

namespace WPHeadless\Auth\Models;

use WPHeadless\Auth\Services\Database;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\ClientTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

class Client implements ClientEntityInterface, Contracts\Entity
{
    use EntityTrait, ClientTrait, Traits\Entity;

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setRedirectUri($uri)
    {
        $this->redirectUri = $uri;
    }

    public static function getTable(): string
    {
        return Database::getClientsTable();
    }   
    
    public static function hydrate(array $row): Contracts\Entity
    {
        $token = new Client;

        $token->setIdentifier($row['id']);

        $token->setName($row['name']);

        $token->setRedirectUri($row['redirect']);

        foreach ($row as $key => $value) {
            $token->$key = $value;
        }

        return $token;
    }    
}
