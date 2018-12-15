<?php

namespace app\controller;

use app\controller\response\Success;
use app\repository\AbstractRepository;
use app\repository\UsersRepository;

class Users {

	static function index($req, $res) {
		$usersRepo = new UsersRepository();

		$users = $usersRepo->query()->retrieve();

		return new Success($res, $users);
	}

	static function get($req, $res) {
        $usersRepo = new UsersRepository();

		$user = $usersRepo->getById($req->id);

		return new Success($res, $user);
	}
}