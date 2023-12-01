<?php

namespace App\Validator\RouterValidators;

use App\Exceptions\NotAllowedMethodRouteException;
use App\Validator\Interfaces\IAllowedRouterMethodsValidator;

class AllowedRouteMethodsValidator implements IAllowedRouterMethodsValidator
{
  protected array $allowedMethods = [
    'GET',
    'POST',
    'PATCH',
    'PUT',
    'DELETE',
    'HEAD',
    'OPTIONS'
  ];

  public function validate(mixed $routeMethod): void
  {
    if (!in_array($routeMethod, $this->allowedMethods)) {
      throw new NotAllowedMethodRouteException();
    }
  }
}