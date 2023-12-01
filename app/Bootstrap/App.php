<?php

namespace App\Bootstrap;

use App\Bootstrap\Interfaces\IRouterDispatcher;
use App\Bootstrap\Interfaces\IRouterResolver;

class App
{
  public function __construct(IRouterDispatcher $routerDispatcher, IRouterResolver $routeResolver)
  {
    $appRoutes = $routerDispatcher->createAppRoutes();
    $routeResolver->resolveRoute($appRoutes);
  }
}
