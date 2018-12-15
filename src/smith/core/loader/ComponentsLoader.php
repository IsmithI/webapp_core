<?php

namespace smith\core\loader;

use smith\core\components\Component;

class ComponentsLoader implements Loader {

	private $config;

	public function __construct() {
		$this->config = \smith\core\ConfigReader::read();
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