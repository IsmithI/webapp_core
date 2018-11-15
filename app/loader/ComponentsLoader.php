<?php

namespace app\loader;

class ComponentsLoader implements Loader {

	private $config;

	public function __construct() {
		$this->config = \app\ConfigReader::read();


    }

	function load( $callback ) {
		$componentsDir = $this->config["components"]["directory"];

		$Directory = new \RecursiveDirectoryIterator($componentsDir);
		$Iterator = new \RecursiveIteratorIterator($Directory);
		$Regex = new \RegexIterator($Iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

		foreach ($Iterator as $file) {
			if ($file->getExtension() == 'php') {
				$className = str_replace(".php", "", str_replace("/", "\\", $file));

				$model = new $className();
				$callback($model);
			}
		}
	}

}