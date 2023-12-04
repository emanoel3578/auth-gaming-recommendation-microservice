<?php

namespace App\Factories\Interfaces;

use App\Bootstrap\Router\RouterDispatcher;

interface IRouterDispatcherFactory
{
  public static function make(): RouterDispatcher;
}