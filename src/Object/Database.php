<?php

namespace Lunar\Object;

use Lunar\Interface\DB;
use PDO, PDOStatement;
use stdClass;

class Database implements DB
{
    protected ?PDO $pdo;
    protected ?PDOStatement $statement;
    protected array $default_options = [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_STRINGIFY_FETCHES => true,
    ];
    protected array $options = [];

	public function __construct(array $options = [])
	{
        $this->options = array_replace($this->default_options, $options);
        $this->pdo = $this->connect();
	}

    public function connect(): mixed
    {
		return true;
    }

    public function disconnect(): bool
    {
        $this->pdo = $this->statement = null;
		return true;
    }

    public function run(string $sql, array $args = []): bool|PDOStatement
    {
        if (empty($args)) {
            return $this->pdo->query($sql);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        $this->statement = $stmt ?? null;
        return $stmt;
    }

    public function query(string $sql, ...$args): bool|PDOStatement
    {
        return count($args) > 0 ? $this->run($sql, $args) : $this->run($sql);
    }

    public function fetch(string $sql, ...$args): bool|stdClass
    {
        $stmt = $this->run($sql, $args);
        return $stmt ? $stmt->fetchObject() : false;
    }

    public function fetchAll(string $sql, ...$args): array|bool
    {
        $stmt = $this->run($sql, $args);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_OBJ) : false;
    }

    public function var(string $sql, ...$args): mixed
    {
        $stmt = $this->run($sql, $args);
        return $stmt->fetchColumn();
    }

    public function column(string $sql, ...$args): array|bool
    {
        $stmt = $this->run($sql, $args);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function __call($method, $args)
    {
        return $this->pdo->$method(...$args);
    }

    public function lastInsertId(?string $name = null): string|false
    {
        return $this->pdo->lastInsertId($name);
    }

    public function beginTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->pdo->commit();
    }

    public function rollBack(): bool
    {
        return $this->pdo->rollBack();
    }

    public function inTransaction(): bool
    {
        return $this->pdo->inTransaction();
    }

    public function errorCode(): ?string
    {
        return $this->pdo->errorCode();
    }
}
