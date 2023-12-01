<?php

namespace App\Bootstrap;

use App\Adapters\Interfaces\IRouterAdapter;
use App\Bootstrap\Interfaces\IRouterDispatcher;
use App\Bootstrap\Interfaces\IRouterResolver;
use App\Formatters\Interfaces\IFormatter;
use App\Routes\Api\DeclaredRoutes;
use App\Validator\Interfaces\IRouterValidator;

class RouterDispatcher implements IRouterDispatcher
{
  protected IRouterAdapter $routerAdapter;
  protected DeclaredRoutes $declaredRoutes;
  protected IRouterValidator $routerValidator;
  protected IRouterResolver $routerResolver;
  protected IFormatter $routeHandlerFormatter;

  public function __construct(
    IRouterAdapter $routerAdapter,
    DeclaredRoutes $declaredRoutes,
    IRouterValidator $routerValidator,
    IRouterResolver $routerResolver,
    IFormatter $routeHandlerFormatter
    )
  {
    $this->routerAdapter = $routerAdapter;
    $this->declaredRoutes = $declaredRoutes;
    $this->routerValidator = $routerValidator;
    $this->routerResolver = $routerResolver;
    $this->routeHandlerFormatter = $routeHandlerFormatter;
  }

  public function createAppRoutes(): array
  {
    return $this->routerAdapter->createRoutes($this->getAppRoutes());
  }

  private function getAppRoutes(): array
  {
    $routes = $this->declaredRoutes->getRoutes();
    $this->routerValidator->validate($routes);
    return $this->routeHandlerFormatter->format($routes);
  }

}