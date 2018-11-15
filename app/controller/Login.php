<?php

namespace app\controller;

use \app\model\Auth;
use \app\model\Users;
use \app\controller\response\LoginFailed;
use \app\controller\response\LoggedOut;

class Login {

    static function get_index($req, $res, $service, $app) {
        return $app->twig->render("login.html");
    }

	static function index($req, $res, $service, $app) {
		$user = $app->user;

		if ($user) 					return $res->json(["success" => true, "user" => $user->toArray()]);
		if ($req->user == null) 	return (new LoginFailed($res))->send();

		$user = new Users($req->user);
		$users = Users::all()->filter(function ($u) use ($user) {
			return $u->email == $user->email && $u->password == md5($user->password);
		});

		if ($users->count() > 0) {
			$user = $users->get(0);
			Auth::authenticateUser($user, $service->startSession());
			
			return $res->json(["success" => true, "user" => $user]);
		}
		else 
			return (new LoginFailed($res))->send();
	}

	static function register($req, $res, $service) {
		if ($req->user == null) 	return $res->json(["success" => false, "message" => "Email or password are incorrect!"]);

		$user = new Users($req->user);
		$user->password = md5($user->password);
		$user->save();

		Auth::authenticateUser($user, $service->startSession());

		return $res->json(["success" => true, "user" => $user->toArray()]);
	}

	static function logout($req, $res, $service, $app) {
		Auth::invalidateSession($service->startSession());

		return (new LoggedOut($res))->send();
	}


}