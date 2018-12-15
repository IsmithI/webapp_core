<?php

namespace Core;

class ConfigReader {

	public const PATH = __DIR__ . "/config.json";
	public const DB_CONFIG_PATH = "config/database.json";

	public static function read() {
		$config = \json_decode(\file_get_contents(self::PATH), true);
		return $config;
	}

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function db() {
	    if (!file_exists(self::DB_CONFIG_PATH)) throw new \Exception("Can't find `database.json` in config/");

        $config = json_decode(file_get_contents(self::DB_CONFIG_PATH), true);
        return $config;
    }

}