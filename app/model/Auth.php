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
			"session_id" => $session_id,
			"end_date" => null
		]);
		if (!$session) return false;
		
		$user = Users::one(['id' => $session["user_id"]]);
		return $user;
	}

	public static function authenticateUser($user, $session_id) {
		$db = DB::getInstance();

		$db->insert("sessions", [
			"user_id" => $user->id,
			"session_id" => $session_id
		]);
	}

	public static function invalidateSession($session_id) {
		$db = DB::getInstance();
		$db->delete("sessions", ["session_id" => $session_id]);
	}
}