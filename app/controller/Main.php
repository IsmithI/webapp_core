<?php

namespace app\controller;

class Main extends SecuredController {

	static function index($req, $res, $service, $app) {
		return $app->twig->render("index.html", ["user" => $app->user]);
	}

}