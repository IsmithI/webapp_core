<?php

namespace app\controller;

<<<<<<< HEAD
class Main implements Controller {
=======
class Main extends SecuredController {
>>>>>>> upoli

	static function index($req, $res, $service, $app) {
		return $app->twig->render("index.html", ["user" => $app->user]);
	}

}