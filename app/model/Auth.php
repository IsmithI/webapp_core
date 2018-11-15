<?php

namespace app\model;

use app\repository\AbstractRepository;
use app\repository\UsersRepository;
use \app\utils\DB;

class Auth {


	public static function get(string $session_id) {
		$db = DB::getInstance();

		$session = $db->get("sessions", [
			"user_id[Int]"
		], [
			"session_id" => $session_id,
			"end_date" => null
		]);
		if (!$session) return false;

		$usersRepo = new UsersRepository();
		
		$user = $usersRepo->all()->filter($usersRepo->byId($session["user_id"]))->pop();
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