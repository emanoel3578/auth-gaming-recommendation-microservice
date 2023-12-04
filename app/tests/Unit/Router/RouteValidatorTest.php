<?php

use App\Exceptions\DuplicatedRoutesDeclared;
use App\Exceptions\RouteMissingDeclaredInformationException;
use App\Validator\RouterValidators\AllowedRouteMethodsValidator;
use App\Validator\RouterValidators\RouteClassHandlerValidator;
use App\Validator\RouterValidators\RouteUriValidator;
use App\Validator\RouterValidators\RouteValidator;
use PHPUnit\Framework\TestCase;

class RouteValidatorTest extends TestCase
{
  private RouteValidator $sut;

  protected function setUp(): void
  {
    parent::setUp();
    $routeMethodsValidator = new AllowedRouteMethodsValidator;
    $routeUriValidator = new RouteUriValidator;
    $routeHandlerValidator = new RouteClassHandlerValidator;
    $this->sut = new RouteValidator($routeMethodsValidator, $routeUriValidator, $routeHandlerValidator);
  }

  public function test_should_validate_true_for_valid_routes()
  {
    $routes = [
      [
        'method' => 'GET',
        'uri' => '/test',
        'handler' => $this->createRouteHandler()
      ],
      [
        'method' => 'GET',
        'uri' => '/test-handler',
        'handler' => $this->createRouteHandler()
      ],
    ];

    $result = $this->sut->validate($routes);

    $this->assertTrue($result);
  }

  public function test_should_validate_true_if_routes_are_declared()
  {
    $routes = [];

    $result = $this->sut->validate($routes);

    $this->assertTrue($result);
  }

  /**
   * @dataProvider declaredRoutesMissingDataCases
   */
  public function test_should_throw_exception_if_any_declared_route_basic_info_is_empty($routes)
  {
    $this->expectException(RouteMissingDeclaredInformationException::class);
    $this->sut->validate($routes);
  }

  public function test_should_throw_exception_if_duplicated_declared_routes()
  {
    $handler = $this->createRouteHandler();
    $routes = [
      [
        'method' => 'GET',
        'uri' => '/test',
        'handler' => $handler
      ],
      [
        'method' => 'GET',
        'uri' => '/test',
        'handler' => $handler
      ],
    ];

    $exception = new DuplicatedRoutesDeclared();
    $this->expectException($exception::class);
    $this->expectExceptionMessage($exception->message);

    $this->sut->validate($routes);
  }

  private function createRouteHandler(): array
  {
    $newClass = new class() {};
    return [$newClass::class];
  }

  public static function declaredRoutesMissingDataCases(): array
  {
    $newclass = new class() {};

    return [
      'missing_method' => [
        'routes' => [
          [
            'uri' => '/test',
            'handler' => [$newclass::class]
          ],
        ]
      ],
      'missing_uri' => [
        'routes' => [
          [
            'method' => 'GET',
            'handler' => [$newclass::class]
          ],
        ]
      ],
      'missing_handler' => [
        'routes' => [
          [
            'method' => 'GET',
            'uri' => '/test',
          ],
        ]
      ]
    ];
  }
}