<?php

namespace App\Formatters\Router;

use App\Bootstrap\ClassResolver;
use App\Formatters\Interfaces\IFormatter;

class RouteHandlerFormatter implements IFormatter
{
  public function format(mixed $routes): mixed
  {
    return array_map(function($route) {
      if (!empty($route['handler'][ClassResolver::METHOD_NAME_INDEX])) {
        $route['handler'] = $route['handler'][ClassResolver::CLASS_NAME_INDEX] . '@' . $route['handler'][ClassResolver::METHOD_NAME_INDEX];
        return $route;
      }

      $route['handler'] = $route['handler'][ClassResolver::CLASS_NAME_INDEX];
      return $route;
    }, $routes);
  }
}