<?php

namespace app;

class ConfigReader {

	public const PATH = "app/config.json";

	public static function read() {
		$config = \json_decode(\file_get_contents(self::PATH), true);
		return $config;
	}

}