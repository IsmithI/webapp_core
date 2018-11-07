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
		$controllerLoader->load( function ($route) {
			$this->router->respond(...$route);
		});

		$this->router->onHttpError( '\app\HttpErrorHandler::handle' );
	}

	public function onHttpError( $callback ) {
		$this->router->onHttpError( $callback );
	}

}