<?php

namespace Lunar\Connection;

use Lunar\Object\Database;
use PDO;
use PDOException;

class MySQL extends Database
{
	public function __construct(
		private string $dbname,
		private string $username,
		private string $password,
		private string $host = "127.0.0.1",
		private int $port = 3306,
		private string $charset = "utf8mb4",
		protected array $options = []
	) {
		parent::__construct($options);
	}

	public function connect(): mixed
	{
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=%s;port=%s",
            $this->host,
			$this->dbname,
			$this->charset,
            $this->port,
        );

        try {
            return new PDO($dsn, $this->username, $this->password, $this->options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
	}
}
