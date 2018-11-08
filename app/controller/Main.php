<?php

namespace app\controller;

class Main {

	static function index($req, $res, $service, $app) {
		return "Hello, ".$service->startSession();
	}

	static function auth($req, $res, $service, $app) {
		return Authentication::auth($req, $res, $service, $app);
	}

}