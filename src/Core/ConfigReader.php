<?php

namespace Core;

class ConfigReader {

	public const PATH = __DIR__ . "/config.json";
	public const DB_CONFIG_PATH = "config/database.json";
	public const ROUTES_CONFIG_PATH = "config/router.json";
	public const MAIN_CONFIG_PATH = "config/main.json";
	public const SOCKETS_CONFIG_PATH = "config/sockets.json";

	public static function read() {
		$config = \json_decode(\file_get_contents(self::PATH), true);
		return $config;
	}

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function db() {
        if (file_exists(self::DB_CONFIG_PATH))
            return json_decode(file_get_contents(self::DB_CONFIG_PATH), true);
        else
            throw new \Exception("Can't find database configuration in config/database.json");
    }

    /**
     * @return mixed
     */
    public static function routes() {
        return file_exists(self::ROUTES_CONFIG_PATH) ?
            json_decode(file_get_contents(self::ROUTES_CONFIG_PATH), true)
            :
            json_decode(file_get_contents(self::PATH), true)["router"];
    }

    /**
     * @return mixed
     */
    public static function main() {
        return file_exists(self::MAIN_CONFIG_PATH) ?
            json_decode(file_get_contents(self::MAIN_CONFIG_PATH), true)
            :
            json_decode(file_get_contents(self::PATH), true);
    }

    public static function components() {
        return file_exists(self::MAIN_CONFIG_PATH) ?
            json_decode(file_get_contents(self::MAIN_CONFIG_PATH), true)["components"]
            :
            json_decode(file_get_contents(self::PATH), true)["components"];
    }

    public static function sockets()
    {
        return file_exists(self::SOCKETS_CONFIG_PATH) ?
            json_decode(file_get_contents(self::SOCKETS_CONFIG_PATH), true)
            :
            json_decode(file_get_contents(self::PATH), true)["sockets"];
    }
}