<?php

namespace app\controller;

class Main extends SecuredController {

	static function index($req, $res, $service, $app) {
		return "Hello, ".$service->startSession();
	}

}