<?php

use App\Bootstrap\App;
use App\Factories\RouterFactory;

require __DIR__ . '/vendor/autoload.php';

$router = RouterFactory::make();
$app = new App($router);

return $app;
