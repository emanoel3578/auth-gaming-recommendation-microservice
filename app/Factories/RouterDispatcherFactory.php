<?php

namespace App\Factories;

use App\Adapters\RouterAdapter;
use App\Bootstrap\RouterDispatcher;
use App\Factories\Interfaces\IFactory;
use App\Routes\Api\DeclaredRoutes;
use App\Validator\RouterValidators\AllowedRouteMethodsValidator;
use App\Validator\RouterValidators\RouteUriValidator;
use App\Validator\RouterValidators\RouteValidator;

class RouterDispatcherFactory implements IFactory
{
  public static function make($data = []): mixed
  {
    $routeAdapter = new RouterAdapter();
    $declaredRoutes = new DeclaredRoutes();
    $routeMethodsValidator = new AllowedRouteMethodsValidator;
    $routeUriValidator = new RouteUriValidator;
    $routeHandlerValidator = RouteHandlerValidatorFactory::make();
    $routeValidator = new RouteValidator($routeMethodsValidator, $routeUriValidator, $routeHandlerValidator);
    $routeResolver = RouterResolverFactory::make();
    
    return new RouterDispatcher($routeAdapter, $declaredRoutes, $routeValidator, $routeResolver);
  }
}