<?php

use App\Bootstrap\App;
use App\Factories\RouterDispatcherFactory;
use App\Factories\RouterResolverFactory;

require_once __DIR__ . '/vendor/autoload.php';

$routerDispatcher = RouterDispatcherFactory::make();
$routerResolver = RouterResolverFactory::make();
$app = new App($routerDispatcher, $routerResolver);

return $app;
