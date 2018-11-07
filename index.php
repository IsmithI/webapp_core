<?php

error_reporting(E_ALL);

require 'vendor/autoload.php';

use \app\App;

$app = new App();
$app->run();