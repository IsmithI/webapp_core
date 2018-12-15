<?php

namespace core;

use Core\controller\NotFound;

class HttpErrorHandler {

	public static function handle($code, $router) {
		switch ($code) {
			case 404:
				NotFound::index($router->request(), $router->response());
				break;
		}
	}
}