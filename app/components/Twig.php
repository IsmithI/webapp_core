<?php

namespace app\components;

use \app\model\Model;
use \app\ConfigReader;

class Twig {

	public $name = 'twig';

	public function __construct() {
		
		$this->handler = function () {
			$config = ConfigReader::read();
			$loader = new \Twig_Loader_Filesystem($config["views"]["templates_dir"]);
			return new \Twig_Environment($loader);
		};
	}

}