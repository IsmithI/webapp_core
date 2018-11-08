<?php

namespace app\model;

use \app\utils\DB;
use \app\model\Users;

class Auth extends Model {


	public static function get(string $session_id) {
		$db = DB::getInstance();

		$session = $db->get("sessions", [
			"user_id[Int]"
		], [
			"session_id" => $session_id
		]);
		if (!$session) return false;
		
		$user = Users::one(['id' => $session["user_id"]]);
		return $user;
	}
}