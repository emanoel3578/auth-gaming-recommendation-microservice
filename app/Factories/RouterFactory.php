<?php

namespace App\Factories;

use App\Adapters\RouterAdapter;
use App\Bootstrap\AppFactory\Router;
use App\Factories\Interfaces\IFactory;
use App\Routes\Api\Routes;
use App\Validator\RouteValidator;

class RouterFactory implements IFactory
{
  public static function make($data = []): mixed
  {
    $routeAdapter = new RouterAdapter();
    $routes = new Routes();
    $routeValidator = new RouteValidator();
    
    return new Router($routeAdapter, $routes, $routeValidator);
  }
}