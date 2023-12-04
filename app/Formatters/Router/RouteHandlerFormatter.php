<?php

namespace App\Formatters\Router;

use App\Formatters\Interfaces\IFormatter;
use App\Validator\RouterValidators\RouteClassHandlerValidator;

class RouteHandlerFormatter implements IFormatter
{
  public function format(mixed $routes): mixed
  {
    return array_map(function($route) {
      if (!empty($route['handler'][RouteClassHandlerValidator::METHOD_NAME_INDEX])) {
        $route['handler'] = $route['handler'][RouteClassHandlerValidator::CLASS_NAME_INDEX] .
        '@' .
        $route['handler'][RouteClassHandlerValidator::METHOD_NAME_INDEX];
        return $route;
      }

      $route['handler'] = $route['handler'][RouteClassHandlerValidator::CLASS_NAME_INDEX];
      return $route;
    }, $routes);
  }
}