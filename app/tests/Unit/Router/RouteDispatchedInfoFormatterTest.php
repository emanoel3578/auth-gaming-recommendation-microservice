<?php

use App\Bootstrap\RouterResolver;
use App\Formatters\Router\RouteDispatchedInfoFormatter;
use PHPUnit\Framework\TestCase;

class RouteDispatchedInfoFormatterTest extends TestCase
{
  private RouteDispatchedInfoFormatter $sut;

  protected function setUp(): void
  {
    parent::setUp();
    $this->sut = new RouteDispatchedInfoFormatter;
  }

  public function test_should_format_dispatched_data_with_only_class_handler_name_given()
  {
    $handlerClassName = 'handlerClassName';
    $dispatchedRouteMockedData = [1, $handlerClassName];

    $formattedDispatchedDataResult = $this->sut->format($dispatchedRouteMockedData);
    
    $this->assertEquals(
      RouterResolver::ROUTE_FOUND,
      $formattedDispatchedDataResult[RouteDispatchedInfoFormatter::STATUS_INDEX_FORMATTED]
    );
    $this->assertEquals(
      $handlerClassName,
      $formattedDispatchedDataResult[RouteDispatchedInfoFormatter::CLASS_NAME_HANDLER_INDEX_FORMATTED]
    );
    $this->assertEmpty(
      $formattedDispatchedDataResult[RouteDispatchedInfoFormatter::METHOD_HANDLER_INDEX_FORMATTED]
    );
    $this->assertEmpty(
      $formattedDispatchedDataResult[RouteDispatchedInfoFormatter::PARAMETERS_INDEX_FORMATTED]
    );
  }

  public function test_should_format_dispatched_data_with_class_handler_name_and_method_handler_name_and_parameters_given()
  {
    $handlerClassName = 'handlerClassName';
    $handlerMethodName = 'methodName';
    $parameters = '?parameters=true';
    $handler = $handlerClassName . '@' . $handlerMethodName;

    $routeStatus = 1;
    $routeAllowedMethods = [];
    $dispatchedRouteMockedData = [$routeStatus, $handler, $routeAllowedMethods, $parameters];

    $formattedDispatchedDataResult = $this->sut->format($dispatchedRouteMockedData);
    $expectedParameters = [$parameters];
    
    $this->assertEquals(
      RouterResolver::ROUTE_FOUND,
      $formattedDispatchedDataResult[RouteDispatchedInfoFormatter::STATUS_INDEX_FORMATTED]
    );
    $this->assertEquals(
      $handlerClassName,
      $formattedDispatchedDataResult[RouteDispatchedInfoFormatter::CLASS_NAME_HANDLER_INDEX_FORMATTED]
    );
    $this->assertEquals(
      $handlerMethodName,
      $formattedDispatchedDataResult[RouteDispatchedInfoFormatter::METHOD_HANDLER_INDEX_FORMATTED]
    );
    $this->assertEquals(
      $expectedParameters,
      $formattedDispatchedDataResult[RouteDispatchedInfoFormatter::PARAMETERS_INDEX_FORMATTED]
    );
  }
}