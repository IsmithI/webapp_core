<?php

header('Access-Control-Allow-Origin: *');

require 'vendor/autoload.php';

use \app\App;

$app = new App();
$app->run();