<?php

namespace App\Bootstrap;

use App\Bootstrap\AppFactory\Router;

class App
{
  public function __construct(Router $router)
  {
    $this->createApp($router);
  }

  private function createApp(Router $router): void
  {
    $appRoutes = $router->createAppRoutes();
    $router->resolveRoute($appRoutes);
  }
}