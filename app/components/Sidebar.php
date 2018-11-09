<?php

namespace app\components;

use \app\model\Model;

class Sidebar {

	public $name = 'sidebar';

	public function __construct() {
		
		$this->handler = function () {
			$model = new Model([
				"home" => "/",
				"users" => "/users"
			]);

			return $model;
		};
	}

}