<?php

namespace Core\utils;

use Core\ConfigReader;
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
                $config = ConfigReader::db();

            } catch (\Exception $e) {
                die($e->getMessage());
            }
            self::$instance = new self($config);
		}
		return self::$instance;
	}

	public function getConfig() {
		return $this->config;
	}

}