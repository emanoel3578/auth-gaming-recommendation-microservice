<?php

namespace App\Factories;

use App\Adapters\RouterAdapter;
use App\Bootstrap\Router\RouterDispatcher;
use App\Factories\Interfaces\IRouterDispatcherFactory;
use App\Formatters\Router\RouteDispatchedInfoFormatter;
use App\Formatters\Router\RouteHandlerFormatter;
use App\Routes\Api\DeclaredRoutes;
use App\Validator\RouterValidators\AllowedRouteMethodsValidator;
use App\Validator\RouterValidators\RouteClassHandlerValidator;
use App\Validator\RouterValidators\RouteUriValidator;
use App\Validator\RouterValidators\RouteValidator;

class RouterDispatcherFactory implements IRouterDispatcherFactory
{
  public static function make(): RouterDispatcher
  {
    $routeDispatchedInfoFormatter = new RouteDispatchedInfoFormatter;
    $routeAdapter = new RouterAdapter();
    $declaredRoutes = new DeclaredRoutes();
    $routeMethodsValidator = new AllowedRouteMethodsValidator;
    $routeUriValidator = new RouteUriValidator;
    $routeHandlerValidator = new RouteClassHandlerValidator;
    $routeValidator = new RouteValidator($routeMethodsValidator, $routeUriValidator, $routeHandlerValidator);
    $routeHandlerFormatter = new RouteHandlerFormatter;
    $routeResolver = RouterResolverFactory::make();
    
    return new RouterDispatcher(
      $routeAdapter,
      $declaredRoutes,
      $routeValidator,
      $routeResolver,
      $routeHandlerFormatter,
      $routeDispatchedInfoFormatter
    );
  }
}