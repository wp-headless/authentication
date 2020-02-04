<?php

namespace WPHeadless\Auth\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use WPHeadless\Auth\Services\Database;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;

class RefreshToken implements RefreshTokenEntityInterface, Contracts\Entity
{
    use RefreshTokenTrait, EntityTrait, Traits\Entity;

    public function save(): void
    {
        global $wpdb;

        if ($this->identifier) {

            $table = static::getTable();

            $format = ['%s', '%s', '%s', '%s'];

            $wpdb->insert($table, [
                'id' => $this->getIdentifier(),
                'access_token_id' => $this->accessToken->getIdentifier(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'expires_at' => Carbon::instance($this->expiryDateTime)->toDateTimeString(),
            ], $format);
        }
    }

    public static function hydrate(array $row): Contracts\Entity
    {
        $token = new RefreshToken;

        $token->setIdentifier($row['id']);

        $expiresAt = CarbonImmutable::parse($row['expires_at']);

        $token->setExpiryDateTime($expiresAt);

        if ($accessToken = AccessToken::getById($row['access_token_id'])) {
            $token->setAccessToken($accessToken);
        }

        foreach ($row as $key => $value) {
            $token->$key = $value;
        }

        return $token;
    }

    public static function getTable(): string
    {
        return Database::getRefreshTokenTable();
    }
}
