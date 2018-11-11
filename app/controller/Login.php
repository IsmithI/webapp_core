<?php

namespace app\controller;

use \app\model\Auth;
use \app\model\Users;
use \app\controller\response\LoginFailed;

class Login {

	static function index($req, $res, $service, $app) {
		$session_id = $service->startSession();
		$user = Auth::get($session_id);

		if ($user) 					return $res->json(["success" => true, "user" => $user->toArray()]);
		if ($req->user == null) 	return (new LoginFailed($res))->send();


	}

	static function register($req, $res, $service) {
		if ($req->user == null) 	return $res->json(["success" => false, "message" => "Email or password are incorrect!"]);

		$user = new Users(json_decode($req->user, true));
		$user->password = md5($user->password);
		$user->save();

		Auth::authenticateUser($user, $service->startSession());

		return $res->json(["success" => true, "user" => $user->toArray()]);
	}


}