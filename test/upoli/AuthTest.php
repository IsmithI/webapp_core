<?php

use \PHPUnit\Framework\TestCase;
use \app\model\Auth;

class AuthTest extends TestCase {

	/** @test */
	public function check_that_we_can_search_db_for_session() {
		
		// Return false for empty session
		$this->assertTrue(!Auth::get(""));

		// Return data for known session
		$this->assert(Auth::get("1234"));
	}
}