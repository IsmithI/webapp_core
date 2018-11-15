<?php

namespace app\middleware;

use \app\controller\response\NotAuthenticated;

class Auth implements Middleware {

	public function handle($req = null, $res = null, $service = null, $app = null) {
		$session_id = $service->startSession();
		$user = \app\model\Auth::get($session_id);		

		if (!$user) return $res->redirect("/login");

		return false;
	}

}