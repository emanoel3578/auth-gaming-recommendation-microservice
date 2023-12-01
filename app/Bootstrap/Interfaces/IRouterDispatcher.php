<?php

namespace App\Bootstrap\Interfaces;

interface IRouterDispatcher
{
  public function createAppRoutes(): array;
}