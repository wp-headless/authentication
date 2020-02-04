<?php

namespace WPHeadless\Auth\Models\Traits;

use Carbon\Carbon;
use WPHeadless\Auth\Models\Contracts\Entity as EntityContract;

trait Entity
{
    public function isRevoked(): bool
    {
        return isset($this->revoked_at) && is_null($this->revoked_at) === false;
    }

    public function revoke(): void
    {
        global $wpdb;

        if ($this->identifier) {

            $table = static::getTable();

            $data = [
                'revoked_at' => Carbon::now()->toDateTimeString(),
            ];

            $where = [
                'id' => $this->identifier,
            ];

            $format = ['%s'];

            $wpdb->update($table, $data, $where, $format);
        }
    }
    
    public static function getById(string $tokenId): ?EntityContract
    {
        global $wpdb;

        $table = static::getTable();

        $query = $wpdb->prepare("SELECT * FROM $table WHERE id = %s", $tokenId);

        if ($row = $wpdb->get_row($query)) {
            return static::hydrate((array) $row);
        }

        return null;
    }   
    
    public function update(array $attributes = []): void
    {
        global $wpdb;

        if ($this->identifier) {

            $table = static::getTable();

            $where = ['id' => $this->identifier];

            foreach ($attributes as $key => $value) {
                if ($value instanceof Carbon) {
                    $attributes[$key] = $value->toDateTimeString();
                }
            }

            $wpdb->update($table, $attributes, $where);
        }
    }   
    
    public function fresh(): EntityContract
    {
        return static::getById($this->identifier);
    }     
}