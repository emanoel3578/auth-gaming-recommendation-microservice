<?php

use App\Bootstrap\Router\ClassResolver;
use PHPUnit\Framework\TestCase;

class ClassResolverTest extends TestCase
{
  private ClassResolver $sut;
  private const EXPECTED_METHOD_CALLED_RETURN = 1;
  private const EXPECTED_METHOD_PARAMETER_RETURN = 2;

  protected function setUp(): void
  {
    parent::setUp();
    $this->sut = new ClassResolver;
  }

  public function test_should_return_instance_of_resolved_class_name_without_handler_method()
  {
    $handlerName = 'newClass';
    $handlerClass = $this->createClassHandler($handlerName);

    $resolvedClassResult = $this->sut->resolveClassName($handlerName, '');

    $this->assertInstanceOf($handlerClass::class, $resolvedClassResult);
  }

  public function test_should_return_instance_of_resolved_class_name_with_handler_method()
  {
    $handlerName = 'newClassWithMethod';
    $handlerMethod = 'handlerMethodCalled';
    $this->createClassHandlerWithMethod($handlerName);

    $resolvedClassResult = $this->sut->resolveClassName($handlerName, $handlerMethod);

    $this->assertEquals(self::EXPECTED_METHOD_CALLED_RETURN, $resolvedClassResult);
  }

  public function test_should_return_instance_of_resolved_class_name_with_handler_method_passing_parameters()
  {
    $handlerName = 'newClassWithMethodAndParameters';
    $handlerMethod = 'handlerMethodCalledParameters';
    $parameters = [self::EXPECTED_METHOD_PARAMETER_RETURN];
    $this->createClassHandlerWithMethodReceveingParameters($handlerName);

    $resolvedClassResult = $this->sut->resolveClassName($handlerName, $handlerMethod, $parameters);

    $this->assertEquals($parameters, $resolvedClassResult);
  }

  private function createClassHandler(string $name): object
  {
    $newClass = new class() {};
    class_alias($newClass::class, $name);

    return $newClass;
  }

  private function createClassHandlerWithMethod(string $name): object
  {
    $newClass = new class() {
      public function handlerMethodCalled() {
        return 1;
      }
    };

    class_alias($newClass::class, $name);

    return $newClass;
  }

  private function createClassHandlerWithMethodReceveingParameters(string $name): object
  {
    $newClass = new class() {
      public function handlerMethodCalledParameters(array $parameter) {
        return $parameter;
      }
    };

    class_alias($newClass::class, $name);

    return $newClass;
  }
}