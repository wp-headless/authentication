<?php

namespace WPHeadless\Auth\Models\Contracts;

interface Entity
{
    public static function getTable(): string;

    public static function hydrate(array $row): Entity;

    public function isRevoked(): bool;

    public function revoke(): void;

    public static function getById(string $tokenId): ?Entity;

    public function fresh(): Entity;

    public function update(array $attributes = []): void;
}