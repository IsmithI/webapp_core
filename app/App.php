<?php

namespace app;

use \app\ConfigReader;
use \app\loader\ControllerLoader;

class App {

	/**
	 * Klein router
	 *
	 * @var \Klein\Klein
	 */
	private $router;

	public function __construct() {
		$this->router = new \Klein\Klein();
	}

	public function run() {
		$this->defineRoutes();
		$this->router->dispatch();
	}

	private function defineRoutes() {
		$controllerLoader = new ControllerLoader();

		$this->router->respond( function ($req, $res, $service, $app) {
			$app->register('twig', function () {
				$config = ConfigReader::read();
				$loader = new \Twig_Loader_Filesystem($config["views"]["templates_dir"]);
				return new \Twig_Environment($loader);
			});
		});

		$controllerLoader->load( function ($route) {
			$this->router->respond(...$route);
		});

		$this->router->onHttpError( '\app\HttpErrorHandler::handle' );
	}

	public function onHttpError( $callback ) {
		$this->router->onHttpError( $callback );
	}

}