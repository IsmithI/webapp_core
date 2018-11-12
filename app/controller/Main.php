<?php

namespace app\controller;

class Main {

	static function index($req, $res, $service, $app) {
		return $app->twig->render("index.html", ["app" => $app]);
	}

}