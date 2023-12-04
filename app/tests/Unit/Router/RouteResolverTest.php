<?php

use App\Bootstrap\Router\ClassResolver;
use App\Bootstrap\RouterResolver;
use App\Exceptions\RouteNotFoundException;
use App\Exceptions\RouteVerbNotAllowed;
use App\Formatters\Router\RouteDispatchedInfoFormatter;
use PHPUnit\Framework\TestCase;

class RouteResolverTest extends TestCase
{
  private RouterResolver $sut;
  protected const ROUTE_STATUS_INDEX = 0;
  protected const FOUND_ROUTE_STATUS = 1;
  protected const ROUTE_NOT_FOUND_STATUS = 0;

  protected function setUp(): void
  {
    parent::setUp();
    $classResolver = new ClassResolver;
    $this->sut = new RouterResolver($classResolver);
  }

  public function test_should_throw_exception_if_route_not_found()
  {
    $routeInfo = [];
    $this->expectException(RouteNotFoundException::class);
    $this->sut->resolveRoute($routeInfo);
  }

  public function test_should_throw_exception_if_route_verb_not_allowed()
  {
    $routeInfo = [
      RouteDispatchedInfoFormatter::STATUS_INDEX_FORMATTED => RouterResolver::METHOD_NOT_ALLOWED,
      RouteDispatchedInfoFormatter::CLASS_NAME_HANDLER_INDEX_FORMATTED => '',
      RouteDispatchedInfoFormatter::METHOD_HANDLER_INDEX_FORMATTED => '',
      RouteDispatchedInfoFormatter::PARAMETERS_INDEX_FORMATTED => []
    ];
    $this->expectException(RouteVerbNotAllowed::class);
    $this->sut->resolveRoute($routeInfo);
  }

  public function test_should_throw_default_exception_if_route_status_invalid()
  {
    $routeInfo = [
      RouteDispatchedInfoFormatter::STATUS_INDEX_FORMATTED => 9999,
      RouteDispatchedInfoFormatter::CLASS_NAME_HANDLER_INDEX_FORMATTED => '',
      RouteDispatchedInfoFormatter::METHOD_HANDLER_INDEX_FORMATTED => '',
      RouteDispatchedInfoFormatter::PARAMETERS_INDEX_FORMATTED => []
    ];
    $this->expectException(RouteNotFoundException::class);
    $this->sut->resolveRoute($routeInfo);
  }

  public function test_should_return_resolved_class_for_found_route_status()
  {
    $class = new class() {};
    $className = 'newClassResolved';
    class_alias($class::class, $className);

    $routeInfo = [
      RouteDispatchedInfoFormatter::STATUS_INDEX_FORMATTED => RouterResolver::ROUTE_FOUND,
      RouteDispatchedInfoFormatter::CLASS_NAME_HANDLER_INDEX_FORMATTED => $className,
      RouteDispatchedInfoFormatter::METHOD_HANDLER_INDEX_FORMATTED => '',
      RouteDispatchedInfoFormatter::PARAMETERS_INDEX_FORMATTED => []
    ];
    $resultClass = $this->sut->resolveRoute($routeInfo);

    $this->assertInstanceOf($class::class, $resultClass);
  }
}