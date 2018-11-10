<?php

namespace app\controller;

use \app\model\Model;
use \app\model\Auth;
use \app\controller\response\NotAuthenticated;

class Authentication {

	/**
	 * Authentication model
	 *
	 * @var Model
	 */
	private static $model = false;

	private function __construct() {}

	
	public static function get() {
		return self::$model;
	}

	public static function auth($req, $res, $service, $app) {
		$session = $service->startSession();
		
		if (!$user = Auth::get($session))
			return (new NotAuthenticated($res))->send();
	}
}