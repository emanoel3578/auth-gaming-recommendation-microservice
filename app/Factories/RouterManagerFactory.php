<?php

namespace App\Factories;

use App\Bootstrap\Router\HttpRouterManager;
use App\Factories\Interfaces\IRouterManagerFactory;

class RouterManagerFactory implements IRouterManagerFactory
{
  public static function make(): HttpRouterManager
  {
    $routerDispatcher = RouterDispatcherFactory::make();
    $routerResolver = RouterResolverFactory::make();
    return new HttpRouterManager($routerDispatcher, $routerResolver);
  }
}