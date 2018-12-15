<?php

namespace smith\core\controller;

class NotFound {

	public static function index($req, $res) {
		return $res->body('Oops, the page is not found!');
	}
}