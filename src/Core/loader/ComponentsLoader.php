<?php

namespace Core\loader;

use Core\components\Component;
use Core\ConfigReader;

class ComponentsLoader implements Loader {

	private $config;

	public function __construct() {
	    $this->config = ConfigReader::components();
    }

	function load( $callback ) {
	    if (!file_exists($this->config["directory"])) return;

		$Directory = new \RecursiveDirectoryIterator($this->config["directory"]);
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