<?php

namespace smith\core\utils;

use \Medoo\Medoo;

class DB extends Medoo {

	private static $instance = null;
	private $config;

	private function __construct(array $options) {
		parent::__construct($options);
		$this->config = $options;
	}

	public static function getInstance() {
		if (is_null(self::$instance)) {
			$config = \smith\core\ConfigReader::read()["db"];
			self::$instance = new self($config);
		}
		return self::$instance;
	}

	public function getConfig() {
		return $this->config;
	}

}