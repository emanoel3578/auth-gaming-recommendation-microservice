<?php

namespace App\Bootstrap\Router;

use App\Bootstrap\Interfaces\IHttpRouterManager;
use App\Bootstrap\Interfaces\IRouterDispatcher;
use App\Bootstrap\Interfaces\IRouterResolver;

class HttpRouterManager implements IHttpRouterManager
{
  private IRouterDispatcher $routerDispatcher;
  private IRouterResolver $routeResolver;

  public function __construct(IRouterDispatcher $routerDispatcher, IRouterResolver $routeResolver)
  {
    $this->routerDispatcher = $routerDispatcher;
    $this->routeResolver = $routeResolver;
  }

  public function handleRouting(): void
  {
    $appRoutes = $this->routerDispatcher->createAppRoutes();
    $this->routeResolver->resolveRoute($appRoutes);
  }
}