<?php

namespace App\Adapters\Interfaces;

interface IRouterAdapter
{
  public function createRoutes(array $routes): array;
}
