<?php

namespace app\model;

use \app\utils\DB;

class Auth extends Model {


	public static function get(string $session_id) {
		$db = DB::getInstance();

		$data = $db->get("sessions", [
			"[>]users" => ["user_id" => "id"]
		], [
			"users.id[Int]",
			"users.role",
			"users.attributes[Json]"
		], [
			"sessions.session_id" => $session_id
		]);

		if (!$data) return false;

		$model = new \app\model\Users($data);
	}
}