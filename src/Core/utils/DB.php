<?php

namespace Core\utils;

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
            try {
                $config = \Core\ConfigReader::db();

            } catch (\Exception $e) {
                die();
            }
            self::$instance = new self($config);
		}
		return self::$instance;
	}

	public function getConfig() {
		return $this->config;
	}

}