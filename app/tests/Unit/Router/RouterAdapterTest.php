<?php

use App\Adapters\RouterAdapter;
use PHPUnit\Framework\TestCase;

class RouterAdapterTest extends TestCase
{
  private RouterAdapter $sut;
  protected const FOUND_ROUTE_STATUS = 1;
  protected const ROUTE_NOT_FOUND_STATUS = 0;
  protected const ROUTE_STATUS_INDEX = 0;
  protected const ROUTE_PARAMS_INDEX = 3;

  protected function setUp(): void
  {
    parent::setUp();
    
    $this->sut = new RouterAdapter;
  }

  public function test_should_adapter_return_found_valid_route_dispatched_info()
  {
    $method = 'GET';
    $uri = '/test';

    $routes = [
      [
        'method' => 'GET',
        'uri' => '/test',
        'handler' => $this->createRouteHandler()
      ]
    ];

    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri;

    $foundRouteResult = $this->sut->createRoutes($routes);

    $this->assertIsArray($foundRouteResult);
    $this->assertEquals(self::FOUND_ROUTE_STATUS, $foundRouteResult[self::ROUTE_STATUS_INDEX]);
    $this->assertEmpty($foundRouteResult[self::ROUTE_PARAMS_INDEX]);
  }

  public function test_should_adapter_return_no_found_status_for_not_declared_route()
  {
    $method = 'GET';
    $uri = '/not-found-route';

    $routes = [];

    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri;

    $foundRouteResult = $this->sut->createRoutes($routes);

    $this->assertIsArray($foundRouteResult);
    $this->assertEquals(self::ROUTE_NOT_FOUND_STATUS, $foundRouteResult[self::ROUTE_STATUS_INDEX]);
  }

  public function test_should_adapter_return_get_request_parameters_for_found_route()
  {
    $method = 'GET';
    $uri = '/test';
    $params = '?query=test-paramater';

    $routes = [
      [
        'method' => 'GET',
        'uri' => '/test',
        'handler' => $this->createRouteHandler()
      ]
    ];

    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri . $params;

    $foundRouteResult = $this->sut->createRoutes($routes);

    $this->assertIsArray($foundRouteResult);
    $this->assertEquals(self::FOUND_ROUTE_STATUS, $foundRouteResult[self::ROUTE_STATUS_INDEX]);
    $this->assertEquals($params, $foundRouteResult[self::ROUTE_PARAMS_INDEX]);
  }

  private function createRouteHandler(): array
  {
    $newClass = new class() {};
    return [$newClass::class];
  }
}