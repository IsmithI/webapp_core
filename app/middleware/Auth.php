<?php

namespace app\middleware;

use \app\controller\response\NotAuthenticated;

class Auth implements Middleware {

	public function handle($req = null, $res = null, $service = null, $app = null) {
		if ($req->hash == null) return (new NotAuthenticated($res))->send();
	}

}