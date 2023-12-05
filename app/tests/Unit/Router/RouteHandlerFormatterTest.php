<?php

use App\Formatters\Router\RouteHandlerFormatter;
use PHPUnit\Framework\TestCase;

class RouteHandlerFormatterTest extends TestCase
{
  private RouteHandlerFormatter $sut;

  protected function setUp(): void
  {
    parent::setUp();
    $this->sut = new RouteHandlerFormatter;
  }

  public function test_should_format_handler_with_only_class_given() 
  {
    $classHandler = 'ClassTesting';
    $method = 'GET';
    $uri = '/mocked';

    $mockedRoutes = [
      [
        'method' => $method,
        'uri' => $uri,
        'handler' => [$classHandler]
      ]
    ];

    $formattedRoutes = $this->sut->format($mockedRoutes);
    $expectedRoutes = [
      [
        'method' => $method,
        'uri' => $uri,
        'handler' => $classHandler
      ]
    ];

    $this->assertEquals($expectedRoutes, $formattedRoutes);
  }

  public function test_should_format_handler_with_class_given_and_method_handler_given()
  {
    $classHandler = 'ClassTesting';
    $classMethodHandler = 'testHandler';
    $method = 'GET';
    $uri = '/mocked';

    $mockedRoutes = [
      [
        'method' => $method,
        'uri' => $uri,
        'handler' => [$classHandler, $classMethodHandler]
      ]
    ];

    $formattedRoutes = $this->sut->format($mockedRoutes);
    $expectedRoutes = [
      [
        'method' => $method,
        'uri' => $uri,
        'handler' => $classHandler.'@'.$classMethodHandler
      ]
    ];

    $this->assertEquals($expectedRoutes, $formattedRoutes);
  }
}