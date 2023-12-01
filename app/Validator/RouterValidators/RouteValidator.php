<?php

namespace App\Validator\RouterValidators;

use App\Exceptions\RouteMissingDeclaredInformationException;
use App\Validator\Interfaces\IAllowedRouterMethodsValidator;
use App\Validator\Interfaces\IRouterHandlerValidator;
use App\Validator\Interfaces\IRouterUriValidator;
use App\Validator\Interfaces\IRouterValidator;

class RouteValidator implements IRouterValidator
{
  protected IAllowedRouterMethodsValidator $routeMethodsValidator;
  protected IRouterUriValidator $routeUriValidator;
  protected IRouterHandlerValidator $routeHandlerValidator;

  public function __construct(
    IAllowedRouterMethodsValidator $routeMethodsValidator,
    IRouterUriValidator $routeUriValidator,
    IRouterHandlerValidator $routeHandlerValidator
  )
  {
    $this->routeMethodsValidator = $routeMethodsValidator;
    $this->routeUriValidator = $routeUriValidator;
    $this->routeHandlerValidator = $routeHandlerValidator;
  }

  public function validate(mixed $routes): bool
  {
    foreach($routes as $route) {
      $this->validateDeclaredRoute($route);
    }

    return true;
  }

  public function validateDeclaredRoute(array $route): void
  {
    if (empty($route['method']) || empty($route['uri']) || empty($route['handler'])) {
      throw new RouteMissingDeclaredInformationException();
    }

    $this->routeMethodsValidator->validate($route['method']);
    $this->routeUriValidator->validate($route['uri']);
    $this->routeHandlerValidator->validate($route['handler']);
  }
}