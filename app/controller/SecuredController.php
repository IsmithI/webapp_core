<?php

namespace app\controller;

class SecuredController {

	static function auth($req, $res, $service, $app) {
		return Authentication::auth($req, $res, $service, $app);
	}
}