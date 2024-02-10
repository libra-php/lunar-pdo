<?php

namespace Lunar\Connection;

use Lunar\Object\Database;
use PDO;
use PDOException;

class SQLite extends Database
{
	public function __construct(
		private string $path,
		protected array $options = []
	) {
		parent::__construct($options);
	}

	public function connect(): mixed
	{
        $dsn = sprintf("sqlite:%s", $this->path);
        try {
            return new PDO(dsn: $dsn, options: $this->options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int) $e->getCode());
        }
	}
}
