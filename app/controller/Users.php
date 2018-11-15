<?php

namespace app\controller;

use \app\controller\response\NotAuthenticated;

class Users {

	static function index($req, $res) {
		$users = \app\model\Users::all();

		return $res->body($users->toJson());
	}

	static function get($req, $res) {
		$user = \app\model\Users::one(['id' => $req->id]);
		return $res->body($user->toJson());
	}

	static function getCurrent($req, $res, $service, $app) {
		$user = $app->user;

		if (!$user) return (new NotAuthenticated($res))->send();

		return $res->json(["success" => true, "user" => $user->toArray()]);
	}
}