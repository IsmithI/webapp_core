<?php

use \PHPUnit\Framework\TestCase;
use Core\utils\DB;

class DBTest extends TestCase {


	/** @test */
	public function can_get_raw_db_client() {
		$db = DB::getInstance();

		$this->assertNotNull($db);
		$this->assertInstanceOf(Medoo\Medoo::class, $db);
	}

	/** @test */
	public function can_fetch_users_data_from_db() {
		$db = DB::getInstance();
		$users = $db->select('users', ['id[Int]', 'deleted[Bool]', 'attributes[Json]']);

		$this->assertNotNull($users);
		$this->assertTrue(is_array($users));
		
		foreach ($users as $user) $this->assertTrue($user["id"] > 0);
	}
}
