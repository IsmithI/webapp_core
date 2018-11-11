<?php

namespace app\loader;

use \app\model\Model;

class ControllerLoader implements Loader {

	private $config;

	public function __construct() {
		$this->config = \app\ConfigReader::read();
	}

	public function load( $callback ) {
		$routes = $this->config["router"];

		foreach ($routes["web"] as $controller => $routes) {
			$controller = \class_exists("\app\controller\\".$controller) ?
							"\app\controller\\".$controller
							:
							false;

			if ($controller) {
				foreach ($routes as $route) {					
					$controllerModel = new Model();

					if (array_key_exists("method", $route))
						$controllerModel->method = $route["method"];

					$controllerModel->path = $route["path"];
					$controllerModel->name = array_key_exists("name", $route) ? "$controller::".$route["name"] : "$controller::"."index"; 

					if (array_key_exists("middleware", $route)) {
						$controllerModel->middleware = [];

						foreach($route["middleware"] as $middleware)
							if (\class_exists("app\\middleware\\$middleware"))
								$controllerModel->middleware[] = "app\\middleware\\$middleware";
					}
	
					$callback($controllerModel);
				}
			}
		}
	}
}