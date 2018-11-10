<?php

namespace app\controller;

use \app\controller\response\LoginFailed;

class Login {

	static function index($req, $res) {
		if ($req->user == null) return (new LoginFailed($res))->send();
	}


}