<?php

namespace app\components;

use \app\model\Auth;

class CurrentUser {

	public $name = 'user';

	public function __construct() {
		
		$this->handler = function ($req, $res, $service, $app) {
			return Auth::get($service->startSession());;
		};
	}

}