<?php

namespace WPHeadless\Auth\Models\Contracts;

interface Token
{
    public static function getTable(): string;

    public static function hydrate(array $row): Token;

    public function isRevoked(): bool;

    public function revoke(): void;

    public static function getById(string $tokenId): ?Token;
}