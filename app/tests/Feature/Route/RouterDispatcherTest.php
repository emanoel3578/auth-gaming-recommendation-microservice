<?php

use App\Adapters\RouterAdapter;
use App\Bootstrap\Router\RouterDispatcher;
use App\Bootstrap\RouterResolver;
use App\Factories\RouterResolverFactory;
use App\Formatters\Router\RouteDispatchedInfoFormatter;
use App\Formatters\Router\RouteHandlerFormatter;
use App\Routes\Api\DeclaredRoutes;
use App\Validator\RouterValidators\AllowedRouteMethodsValidator;
use App\Validator\RouterValidators\RouteClassHandlerValidator;
use App\Validator\RouterValidators\RouteUriValidator;
use App\Validator\RouterValidators\RouteValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RouterDispatcherTest extends TestCase
{
  protected RouterDispatcher $sut;
  protected $declaredRoutesMock;
  protected $routeHandlerValidatorMock;

  protected function setUp(): void
  {
    parent::setUp();
    $routeDispatchedInfoFormatter = new RouteDispatchedInfoFormatter;
    $routeAdapter = new RouterAdapter();
    $this->declaredRoutesMock = $this->createMock(DeclaredRoutes::class);
    $routeMethodsValidator = new AllowedRouteMethodsValidator;
    $routeUriValidator = new RouteUriValidator;
    $this->routeHandlerValidatorMock = $this->createMock(RouteClassHandlerValidator::class);
    $routeValidator = new RouteValidator($routeMethodsValidator, $routeUriValidator, $this->routeHandlerValidatorMock);
    $routeHandlerFormatter = new RouteHandlerFormatter;
    $routeResolver = RouterResolverFactory::make();
    $this->sut = new RouterDispatcher(
      $routeAdapter,
      $this->declaredRoutesMock,
      $routeValidator,
      $routeResolver,
      $routeHandlerFormatter,
      $routeDispatchedInfoFormatter
    );
  }
  
  public function test_should_create_dispatched_routes_when_found_route_with_parameters()
  {
    $method = 'GET';
    $uri = '/mocked';
    $parameters = '?testing-parameters=testing';
    $classHandler = 'ClassTesting';
    $classMethodHandler = 'testHandler';

    $_SERVER['REQUEST_METHOD'] = $method;
    $_SERVER['REQUEST_URI'] = $uri.$parameters;

    $mockedRoutes = [
      [
        'method' => $method,
        'uri' => $uri,
        'handler' => [$classHandler, $classMethodHandler]
      ]
    ];

    $this->declaredRoutesMock->method('getRoutes')->willReturn($mockedRoutes);
    $this->routeHandlerValidatorMock->method('validate')->willReturn(true);

    $foundDispachedRoute = $this->sut->createAppRoutes();
    $expectedParameters = [$parameters];

    $this->assertEquals(
      RouterResolver::ROUTE_FOUND,
      $foundDispachedRoute[RouteDispatchedInfoFormatter::STATUS_INDEX_FORMATTED]
    );
    $this->assertEquals(
      $classHandler, $foundDispachedRoute[RouteDispatchedInfoFormatter::CLASS_NAME_HANDLER_INDEX_FORMATTED]
    );
    $this->assertEquals($classMethodHandler, $foundDispachedRoute[RouteDispatchedInfoFormatter::METHOD_HANDLER_INDEX_FORMATTED]);
    $this->assertEquals($expectedParameters, $foundDispachedRoute[RouteDispatchedInfoFormatter::PARAMETERS_INDEX_FORMATTED]);
  }
}