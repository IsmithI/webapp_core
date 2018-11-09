<?php

namespace app;

use \app\ConfigReader;
use \app\loader\ControllerLoader;
use \app\loader\ComponentsLoader;
use \app\model\Auth;

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
			$componentsLoader = new ComponentsLoader();
			$componentsLoader->load( function ($component) use ($req, $res, $service, $app) {
				
				$app->register( $component->name, function () use ($component, $req, $res, $service, $app) {
					return ($component->handler)($req, $res, $service, $app);
				});
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