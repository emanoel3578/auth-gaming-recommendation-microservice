<?php

namespace App\Factories;

use App\Adapters\RouterAdapter;
use App\Bootstrap\AppFactory\Router;
use App\Factories\Interfaces\IFactory;
use App\Routes\Api\Routes;
use App\Validator\RouterValidators\AllowedRouteMethodsValidator;
use App\Validator\RouterValidators\RouteHandlerValidator;
use App\Validator\RouterValidators\RouteUriValidator;
use App\Validator\RouterValidators\RouteValidator;

class RouterFactory implements IFactory
{
  public static function make($data = []): mixed
  {
    $routeAdapter = new RouterAdapter();
    $routes = new Routes();
    $routeMethodsValidator = new AllowedRouteMethodsValidator;
    $routeUriValidator = new RouteUriValidator;
    $routeHandlerValidator = new RouteHandlerValidator;
    $routeValidator = new RouteValidator($routeMethodsValidator, $routeUriValidator, $routeHandlerValidator);
    
    return new Router($routeAdapter, $routes, $routeValidator);
  }
}