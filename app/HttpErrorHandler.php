<?php

namespace app;

class HttpErrorHandler {

	public static function handle($code, $router) {
		switch ($code) {
			case 404:
				\app\controller\NotFound::index($router->request(), $router->response());
				break;
		}
	}
}