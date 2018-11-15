<?php

namespace app\components;

use \app\model\Auth;
use app\model\Users;

class CurrentUser {

	public $name = 'user';

	public function __construct() {
		
		$this->handler = function ($req, $res, $service, $app) {
			return new Users( (Auth::get($service->startSession()))->toArray() );
		};
	}

}