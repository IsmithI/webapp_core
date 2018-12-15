<?php

namespace smith\core;

use smith\core\controller\NotFound;

class HttpErrorHandler {

	public static function handle($code, $router) {
		switch ($code) {
			case 404:
				NotFound::index($router->request(), $router->response());
				break;
		}
	}
}