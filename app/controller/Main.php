<?php

namespace app\controller;

class Main {

	static function index() {
		return "Hello";
	}

	static function auth($req, $res) {
		$superSecretHash = '1234';
		if ($req->hash != $superSecretHash) {
			$res->body('Not authorized!');
			return $res->send();
		} 
	}

}