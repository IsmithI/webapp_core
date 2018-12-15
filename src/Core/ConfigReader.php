<?php

namespace Core;

class ConfigReader {

	public const PATH = __DIR__ . "/config.json";
	public const DB_CONFIG_PATH = "config/database.json";
	public const ROUTES_CONFIG_PATH = "config/router.json";
	public const MAIN_CONFIG_PATH = "config/main.json";

	public static function read() {
		$config = \json_decode(\file_get_contents(self::PATH), true);
		return $config;
	}

    /**
     * @return mixed
     */
    public static function db() {
        return file_exists(self::ROUTES_CONFIG_PATH) ?
            json_decode(file_get_contents(self::DB_CONFIG_PATH), true)
            :
            json_decode(file_get_contents(self::PATH), true)["db"];
    }

    /**
     * @return mixed
     */
    public static function routes() {
        return file_exists(self::ROUTES_CONFIG_PATH) ?
            json_decode(file_get_contents(self::DB_CONFIG_PATH), true)
            :
            json_decode(file_get_contents(self::PATH), true)["router"];
    }

    /**
     * @return mixed
     */
    public static function main() {
        return file_exists(self::ROUTES_CONFIG_PATH) ?
            json_decode(file_get_contents(self::DB_CONFIG_PATH), true)
            :
            json_decode(file_get_contents(self::PATH), true);
    }
}