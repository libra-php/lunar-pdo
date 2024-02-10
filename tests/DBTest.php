<?php

declare(strict_types=1);

use Lunar\Connection\SQLite;
use Lunar\Interface\DB;
use PHPUnit\Framework\TestCase;

final class DBTest extends TestCase
{
	private DB $db;

	public function setUp(): void
	{
		$this->db = new SQLite(__DIR__ . "/test.db");
	}

	public function testRun(): void
	{
		$results = $this->db->run("SELECT * FROM fake");
		$this->assertNotFalse($results);
	}

	public function testQuery(): void
	{
		$results = $this->db->query("UPDATE fake SET name = ? WHERE value = ?", "one", 1);
		$this->assertNotFalse($results);
	}

	public function testFetch(): void
	{
		$result = $this->db->fetch("SELECT * FROM fake WHERE value = ?", 2);
		$this->assertNotNull($result);
		$this->assertSame("two", $result->name);
	}

	public function testFetchAll(): void
	{
		$results = $this->db->fetchAll("SELECT * FROM fake");
		$this->assertNotFalse($results);
		$this->assertTrue(count($results) > 1);
		$this->assertSame($results[2]->name, "three");
	}

	public function testValue(): void
	{
		$result = $this->db->value("SELECT name FROM fake WHERE value = ?", 3);
		$this->assertSame($result, "three");
	}

	public function testColumn(): void
	{
		$results = $this->db->column("SELECT name FROM fake");
		$this->assertNotFalse($results);
		$this->assertTrue(count($results) > 1);
		$this->assertSame($results, ["one", "two", "three"]);
	}
}
