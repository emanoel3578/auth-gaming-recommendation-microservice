<?php

namespace App\Factories;

use App\Bootstrap\Router\ClassResolver;
use App\Bootstrap\RouterResolver;
use App\Factories\Interfaces\IRouterResolverFactory;
use App\Services\Route\HandlerExtractorService;

class RouterResolverFactory implements IRouterResolverFactory
{
  public static function make(): RouterResolver
  {
    $handlerExtractorService = new HandlerExtractorService;
    $classResolver = new ClassResolver($handlerExtractorService);
    return new RouterResolver($classResolver);
  }
}