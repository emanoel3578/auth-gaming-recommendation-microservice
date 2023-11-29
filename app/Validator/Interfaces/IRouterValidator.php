<?php

namespace App\Validator\Interfaces;

interface IRouterValidator
{
  public function validateDeclaredRoutes(array $routes): void;
}