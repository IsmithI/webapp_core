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
		
		if (!$user = Auth::get($session)) {
			$res->body($app->twig->render('not_authenticated.html'));
			return $res->send();
		}
			// return (new NotAuthenticated($res))->send();
	}
}