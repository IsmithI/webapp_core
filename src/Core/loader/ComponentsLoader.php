<?php

namespace Core\loader;

use Core\components\Component;

class ComponentsLoader implements Loader {

	private $config;

	public function __construct() {
		$this->config = \Core\ConfigReader::read();
    }

	function load( $callback ) {
		$componentsDir = $this->config["components"]["directory"];

		$Directory = new \RecursiveDirectoryIterator($componentsDir);
		$Iterator = new \RecursiveIteratorIterator($Directory);
		$Regex = new \RegexIterator($Iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

		foreach ($Iterator as $file) {
			if ($file->getExtension() == 'php') {
				$className = str_replace(".php", "", str_replace("/", "\\", $file));

				if (class_exists($className)) {
                    $model = new $className();

                    if ($model instanceof Component)
                        $callback($model);
                }
			}
		}
	}

}