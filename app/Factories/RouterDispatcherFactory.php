<?php

namespace App\Factories;

use App\Adapters\RouterAdapter;
use App\Bootstrap\RouterDispatcher;
use App\Factories\Interfaces\IFactory;
use App\Formatters\Router\RouteHandlerFormatter;
use App\Routes\Api\DeclaredRoutes;
use App\Validator\RouterValidators\AllowedRouteMethodsValidator;
use App\Validator\RouterValidators\RouteClassHandlerValidator;
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
    $routeHandlerValidator = new RouteClassHandlerValidator;
    $routeValidator = new RouteValidator($routeMethodsValidator, $routeUriValidator, $routeHandlerValidator);
    $routeHandlerFormatter = new RouteHandlerFormatter;
    $routeResolver = RouterResolverFactory::make();
    
    return new RouterDispatcher($routeAdapter, $declaredRoutes, $routeValidator, $routeResolver, $routeHandlerFormatter);
  }
}