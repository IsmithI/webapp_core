<?php

namespace app;

class ConfigReader {

	public const PATH = "app/config.json";

	public static function read() {
		$config = \json_decode(\file_get_contents(self::PATH), true);

		// foreach ($config["router"] as $group => $routes) {
		// 	foreach ($routes as $key => $route) {
		// 		if (!array_key_exists("method", $route)) {
		// 			$config["router"][$group][$key]["method"] = "*";
		// 		}
		// 	}
		// }
		return $config;
	}

}