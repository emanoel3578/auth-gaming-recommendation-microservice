<?php

namespace App\Factories\Interfaces;

use App\Bootstrap\RouterResolver;

interface IRouterResolverFactory
{
  public static function make(): RouterResolver;
}