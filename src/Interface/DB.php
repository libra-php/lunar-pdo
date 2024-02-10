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
	public function fetch(string $sql, ...$args): ?stdClass;
	public function fetchAll(string $sql, ...$args): array|bool;
	public function value(string $sql, ...$args): mixed;
	public function column(string $sql, ...$args): array|bool;
}
