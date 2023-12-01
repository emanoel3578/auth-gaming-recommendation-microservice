<?php

use App\Exceptions\NotAllowedMethodRouteException;
use App\Validator\RouterValidators\AllowedRouteMethodsValidator;
use PHPUnit\Framework\TestCase;

class AllowedRouteMethodsValidatorTest extends TestCase
{
  public function test_should_throw_exception_when_route_method_is_not_allowed()
  {
    $routeMethod = 'not_valid_route_method';
    $sut = new AllowedRouteMethodsValidator;

    $this->expectException(NotAllowedMethodRouteException::class);
    
    $sut->validate($routeMethod);
  }
}