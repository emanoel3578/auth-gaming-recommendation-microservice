<?php

namespace App\Validator\RouterValidators;

use App\Validator\Interfaces\IRouterHandlerValidator;

class RouteHandlerValidator implements IRouterHandlerValidator
{
  public function validate(mixed $handler): void
  {
    // Implement validation on handler name
  }
}