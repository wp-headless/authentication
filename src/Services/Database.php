<?php

namespace WPHeadless\Auth\Services;

use PDOException;
use ParagonIE\EasyDB\Factory;
use ParagonIE\EasyDB\EasyDB;

class Database
{
    /**
     * @var EasyDB
     */
    protected $connection;

    public function __construct()
    {
        $this->connection = static::createConnection();
    }

    public function install(): void
    {
        $tableSchemas = static::getSchema();

        foreach ($tableSchemas as $tableName => $schema) {
            if (!static::tableExists($tableName)) {
                $this->connection->run($schema);
            }
        }
    }

    public function uninstall(): void
    {
        $tables = static::getTables();

        foreach ($tables as $name) {
            if (static::tableExists($name)) {
                $this->connection->run("DROP TABLE {$name};");
            }
        }
    }

    private static function getSchema(): array
    {
        global $wpdb;

        $collate = $wpdb->get_charset_collate();

        return [
            static::getAccessTokenTable() => "
                CREATE TABLE " . static::getAccessTokenTable() . " (
                    id VARCHAR(100) NOT NULL,
                    user_id MEDIUMINT(9),
                    created_at DATETIME,
                    expires_at DATETIME,
                    revoked_at DATETIME,
                    PRIMARY KEY (id),
                    INDEX user_id (user_id)
                ) $collate;             
            ",
            static::getRefreshTokenTable() => "
                CREATE TABLE " . static::getRefreshTokenTable() . " (
                    id VARCHAR(100) NOT NULL,
                    access_token_id VARCHAR(100) NOT NULL,
                    created_at DATETIME,
                    expires_at DATETIME,
                    revoked_at DATETIME,
                    PRIMARY KEY (id),
                    INDEX access_token_id (access_token_id)
                ) $collate;             
            ",
            static::getClientsTable() => "
                CREATE TABLE " . static::getClientsTable() . " (
                    id VARCHAR(100) NOT NULL,
                    user_id MEDIUMINT(9),
                    name VARCHAR(100),
                    secret VARCHAR(100),
                    redirect TEXT,
                    personal_access_client TINYINT(1),
                    password_client TINYINT(1),
                    created_at DATETIME,
                    revoked_at DATETIME,
                    PRIMARY KEY (id),
                    INDEX user_id (user_id)
                ) $collate;             
            ",            
        ];
    }

    public static function getAccessTokenTable(): string
    {
        global $wpdb;

        $prefix = $wpdb->prefix;

        return "{$prefix}oauth_access_tokens";
    }

    public static function getRefreshTokenTable(): string
    {
        global $wpdb;

        $prefix = $wpdb->prefix;

        return "{$prefix}oauth_refresh_tokens";
    }

    public static function getClientsTable(): string
    {
        global $wpdb;

        $prefix = $wpdb->prefix;

        return "{$prefix}oauth_clients";
    }    

    public static function getTables(): array
    {
        return array_keys(static::getSchema());
    }

    public static function tableExists(string $tableName): bool
    {
        $connection = static::createConnection();

        try {
            $connection->run("SELECT 1 FROM $tableName LIMIT 1;");
        } catch (PDOException $exception) {
            return false;
        }

        return true;
    }

    private static function createConnection(): EasyDB
    {
        return Factory::fromArray([
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USER,
            DB_PASSWORD
        ]);
    }
}
