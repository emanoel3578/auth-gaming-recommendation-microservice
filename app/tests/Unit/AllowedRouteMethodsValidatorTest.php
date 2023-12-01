<?php

use App\Exceptions\NotAllowedMethodRouteException;
use App\Validator\Interfaces\IAllowedRouterMethodsValidator;
use App\Validator\RouterValidators\AllowedRouteMethodsValidator;
use PHPUnit\Framework\TestCase;

class AllowedRouteMethodsValidatorTest extends TestCase
{
  private IAllowedRouterMethodsValidator $sut;

  protected function setUp(): void
  {
    parent::setUp();
    $this->sut = new AllowedRouteMethodsValidator;
  }

  public function test_should_throw_exception_when_route_method_is_not_allowed()
  {
    $routeMethod = 'not_valid_route_method';

    $this->expectException(NotAllowedMethodRouteException::class);
    
    $this->sut->validate($routeMethod);
  }

  public function test_should_sucessfully_validate_allowed_route_method()
  {
    $routeMethod = 'GET';

    $result = $this->sut->validate($routeMethod);

    $this->assertTrue($result);
  }
}