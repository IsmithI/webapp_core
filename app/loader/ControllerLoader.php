<?php

namespace app\loader;

class ControllerLoader implements Loader {

	public function load( $callback ) {
		$routes = \app\ConfigReader::read()["router"];

		foreach ($routes["web"] as $controller => $routes) {
			$controller = \class_exists("\app\controller\\".$controller) ?
							"\app\controller\\".$controller
							:
							false;

			if ($controller) {
				foreach ($routes as $route) {
					$routeArray = [];					
					if (array_key_exists("method", $route)) {
						array_push($routeArray, $route["method"]);
					}
					array_push($routeArray, $route["path"]);
					array_push($routeArray, array_key_exists("name", $route) ? "$controller::".$route["name"] : "$controller::"."index");
	
					$callback($routeArray);
				}
			}
		}
	}
}