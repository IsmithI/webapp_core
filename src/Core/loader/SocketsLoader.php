<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 16.12.18
 * Time: 11:40
 */

namespace Core\loader;


use Core\ConfigReader;
use Core\model\Model;
use Core\sockets\ISocketServer;
use Ratchet\MessageComponentInterface;

class SocketsLoader implements Loader {

    function load($callback)
    {
        $config = new Model(ConfigReader::sockets());

        if ($config->has("directory") && $config->has("namespace")) {

//            if (!file_exists($config->directory)) {
//                print_r($config);
//
//                return;
//            }

            $Directory = new \RecursiveDirectoryIterator($config->directory);
            $Iterator = new \RecursiveIteratorIterator($Directory);
            $Regex = new \RegexIterator($Iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

            foreach ($Iterator as $file) {
                if ($file->getExtension() == 'php') {

                    $className = $config->namespace . str_replace(".php", "", $file->getFileName());

                    if (is_a($className, MessageComponentInterface::class, true) &&
                        !is_a($className, ISocketServer::class, true)) {

                        $model = new $className();

                        $callback($model);
                    }
                }
            }
        }
    }
}