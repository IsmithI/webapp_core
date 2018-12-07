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

        $this->loadComponents();
        $this->setupControllers();

        $this->router->onHttpError( '\app\HttpErrorHandler::handle' );
	}

	public function onHttpError( $callback ) {
		$this->router->onHttpError( $callback );
	}

    private function loadComponents(): void
    {
        $this->router->respond(function ($req, $res, $service, $app) {
            $componentsLoader = new ComponentsLoader();
            $componentsLoader->load(function ($component) use ($req, $res, $service, $app) {

                $app->register($component->name, function () use ($component, $req, $res, $service, $app) {
                    return ($component->handler)($req, $res, $service, $app);
                });
            });
        });
    }


    private function setupControllers(): void {
        $controllerLoader = new ControllerLoader();
        $controllerLoader->load(function ($controller) {
            if ($controller->has("middleware"))
                foreach ($controller->middleware as $middleware) {

                    $handler = new $middleware();

                    if ($controller->has("method"))
                        $this->router->respond(
                            $controller->method,
                            $controller->path,
                            function ($req, $res, $service, $app) use ($handler) {
                                $result = $handler->handle($req, $res, $service, $app);

                                if ($result) {
                                    $result->send();
                                    die();
                                }
                            }
                        );
                    else
                        $this->router->respond(
                            $controller->path,
                            function ($req, $res, $service, $app) use ($handler) {
                                $result = $handler->handle($req, $res, $service, $app);

                                if ($result) {
                                    $result->send();
                                    die();
                                }
                            }
                        );
                }

            if ($controller->has("method"))
                $this->router->respond(
                    $controller->method,
                    $controller->path,
                    $controller->name
                );
            else
                $this->router->respond(
                    $controller->path,
                    $controller->name
                );
        });
    }

}