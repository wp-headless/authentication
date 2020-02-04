<?php

namespace WPHeadless\Auth\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use WPHeadless\Auth\Services\Database;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

class AccessToken implements AccessTokenEntityInterface, Contracts\Entity
{
    use AccessTokenTrait, EntityTrait, TokenEntityTrait, Traits\Entity;

    public function save(): void
    {
        global $wpdb;

        if ($this->identifier) {

            $table = static::getTable();

            $format = ['%s', '%d', '%s', '%s'];

            $wpdb->insert($table, [
                'id' => $this->identifier,
                'user_id' => $this->userIdentifier,
                'created_at' => Carbon::now()->toDateTimeString(),
                'expires_at' => Carbon::instance($this->expiryDateTime)->toDateTimeString(),
            ], $format);
        }
    }

    public static function hydrate(array $row): Contracts\Entity
    {
        $token = new AccessToken;

        $token->setIdentifier($row['id']);

        $expiresAt = CarbonImmutable::parse($row['expires_at']);

        $token->setExpiryDateTime($expiresAt);

        $token->setUserIdentifier($row['user_id']);

        foreach ($row as $key => $value) {
            $token->$key = $value;
        }

        return $token;
    }

    public static function getTable(): string
    {
        return Database::getAccessTokenTable();
    }

    public static function getByUserId(int $userId): ?Contracts\Entity
    {
        global $wpdb;

        $table = static::getTable();

        $query = $wpdb->prepare("SELECT * FROM $table WHERE user_id = %s", $userId);

        if ($row = $wpdb->get_row($query)) {
            return static::hydrate((array) $row);
        }

        return null;
    }     
}
