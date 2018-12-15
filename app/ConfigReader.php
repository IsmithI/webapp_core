<?php

namespace app;

class ConfigReader {

	public const PATH = __DIR__ . "/config.json";

	public static function read() {
		$config = \json_decode(\file_get_contents(self::PATH), true);
		return $config;
	}

}