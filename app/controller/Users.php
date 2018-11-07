<?php

namespace app\controller;

class Users {

	static function index($req, $res) {
		$users = \app\model\Users::all();

		return $res->body($users->toJson());
	}

	static function get($req, $res) {
		$user = \app\model\Users::one(['id' => $req->id]);
		return $res->body($user->toJson());
	}
}