<?php

namespace Core\loader;

use Core\ConfigReader;
use Core\model\Model;

class ControllerLoader implements Loader {

	private $config;

	public function __construct() {
        $this->config = ConfigReader::routes();
    }

	public function load( $callback ) {
		$config = new Model($this->config);

		foreach ($config->web as $controller => $routes) {
			$controller = \class_exists($config->controllers . $controller) ?
                            $config->controllers.$controller
							:
							false;

			if ($controller) {
				foreach ($routes as $route) {
				    $route = new Model($route);
					$controllerModel = new Model();

					if (!$route->has("path")) continue;

					if ($route->has("method"))
						$controllerModel->method = $route->method;

					$controllerModel->path = $route->path;
					$controllerModel->name = $route->has("name") ? "$controller::".$route->name : "$controller::"."index";

					if ($route->has("middleware")) {
						$controllerModel->middleware = [];

						foreach($route->middleware as $middleware)
							if (\class_exists($config->middleware.$middleware))
								$controllerModel->middleware[] = $config->middleware.$middleware;
					}
	
					$callback($controllerModel);
				}
			}
		}
	}
}