<?php

namespace App\Bootstrap\Router;

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
  protected IFormatter $routeDispatchedInfoFormatter;

  public function __construct(
    IRouterAdapter $routerAdapter,
    DeclaredRoutes $declaredRoutes,
    IRouterValidator $routerValidator,
    IRouterResolver $routerResolver,
    IFormatter $routeHandlerFormatter,
    IFormatter $routeDispatchedInfoFormatter
    )
  {
    $this->routerAdapter = $routerAdapter;
    $this->declaredRoutes = $declaredRoutes;
    $this->routerValidator = $routerValidator;
    $this->routerResolver = $routerResolver;
    $this->routeHandlerFormatter = $routeHandlerFormatter;
    $this->routeDispatchedInfoFormatter = $routeDispatchedInfoFormatter;
  }

  public function createAppRoutes(): array
  {
    $createdRoutes = $this->routerAdapter->createRoutes($this->getAppRoutes());
    return $this->routeDispatchedInfoFormatter->format($createdRoutes);
  }

  private function getAppRoutes(): array
  {
    $routes = $this->declaredRoutes->getRoutes();
    $this->routerValidator->validate($routes);
    return $this->routeHandlerFormatter->format($routes);
  }

}