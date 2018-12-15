<?php

use \PHPUnit\Framework\TestCase;
use Core\model\Auth;
use Core\model\DBModel;

class AuthTest {

	
	public function check_that_we_can_search_db_for_session() {
		
		// Return false for empty session
		$this->assertTrue(!Auth::get(""));

		// Return data for known session
		$model = Auth::get("7gfrc6ke3hlmjapg60tm1fq3de");		
		$this->assertInstanceOf(DBModel::class, $model);
		$this->assertEquals("Oleg", $model->first_name);
	}
}