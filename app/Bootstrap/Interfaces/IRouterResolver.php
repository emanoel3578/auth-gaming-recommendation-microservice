<?php

namespace App\Bootstrap\Interfaces;

interface IRouterResolver
{
  public function resolveRoute(array $routeInfo): mixed;
}