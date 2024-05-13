<?php

namespace Lunar\Interface;

use PDOStatement;
use stdClass;

interface DB
{
	public function connect(): mixed;
	public function disconnect(): bool;
	public function run(string $sql, array $args = []): bool|PDOStatement;
	public function query(string $sql, ...$args): bool|PDOStatement;
	public function fetch(string $sql, ...$args): bool|stdClass;
	public function fetchAll(string $sql, ...$args): array|bool;
	public function var(string $sql, ...$args): mixed;
	public function column(string $sql, ...$args): array|bool;
	public function lastInsertId(?string $name = null): string|false;
	public function inTransaction(): bool;
	public function beginTransaction(): bool;
	public function commit(): bool;
	public function rollBack(): bool;
	public function errorCode(): ?string;
}
