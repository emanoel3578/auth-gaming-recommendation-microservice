<?php

use App\Bootstrap\App;
use App\Factories\RouterManagerFactory;

require_once __DIR__ . '/vendor/autoload.php';

$routerManager = RouterManagerFactory::make();
$app = new App($routerManager);

return $app;
