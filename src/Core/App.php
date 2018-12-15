<?php

namespace Core;

use Core\components\Component;
use Core\controller\Controller;
use Core\loader\ComponentsLoader;
use Core\loader\ControllerLoader;
use Core\model\Model;

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

        $this->router->onHttpError( '\smith\core\HttpErrorHandler::handle');
	}

	public function onHttpError( $callback ) {
		$this->router->onHttpError( $callback );
	}

    private function loadComponents(): void
    {
        $this->router->respond(function ($req, $res, $service, \Klein\App $app) {
            $componentsLoader = new ComponentsLoader();
            $componentsLoader->load(function (Component $component) use ($req, $res, $service, $app) {

                $app->register($component->getName(), function () use ($component, $req, $res, $service, $app) {
                    return ($component->getHandler())($req, $res, $service, $app);
                });
            });
        });
    }


    private function setupControllers(): void {
        $controllerLoader = new ControllerLoader();
        $controllerLoader->load(function (Model $controller) {

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