<?php

namespace app\controller;

use app\repository\AbstractRepository;

class Users {

	static function index($req, $res) {
		$usersRepo = new AbstractRepository("users");
		$usersRepo->setAutoFormat(true);
		$usersRepo->setFormat(\app\model\Users::getFormat());
		$users = $usersRepo->all();

		return $res->body($users->toJson());
	}

	static function get($req, $res) {
        $usersRepo = new AbstractRepository("users");
        $usersRepo->setAutoFormat(true);
        $usersRepo->setFormat(\app\model\Users::getFormat());

		$user = $usersRepo->all()->filter( $usersRepo->byId($req->id) );

		return $res->body($user->toJson());
	}
}