<?php

header('Access-Control-Allow-Origin: *');

require 'vendor/autoload.php';

use smith\core\App;

$app = new App();
$app->run();