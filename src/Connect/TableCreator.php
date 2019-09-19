<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\DependencyContainer;
use App\Connect\Config;

$config = Config::init();
$di = new DependencyContainer($config);
$connect = $di->getConnect()->createToDoTable();

echo 'Finished!';