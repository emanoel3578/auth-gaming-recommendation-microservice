<?php

use App\Controllers\TestingController;
use App\Exceptions\GivenHandlerClassDoesntExistException;
use App\Exceptions\RouteHandlerIsNotAValidClass;
use App\Validator\Interfaces\IRouterHandlerValidator;
use App\Validator\RouterValidators\RouteClassHandlerValidator;
use PHPUnit\Framework\TestCase;

class RouteClassHandlerValidatorTest extends TestCase
{
  private IRouterHandlerValidator $sut;

  protected function setUp(): void
  {
    parent::setUp();
    $this->sut = new RouteClassHandlerValidator;
  }

  /**
   * @dataProvider invalidClassNames
   */
  public function test_should_validator_throw_exception_if_handler_is_not_valid($className, $expectedException)
  {
    $this->expectException($expectedException);

    $this->sut->validate($className);
  }

  public function test_should_validator_return_true_for_valid_class_without_method_handler()
  {
    $newClass = new class() {};
    $className = [$newClass::class];

    $result = $this->sut->validate($className);

    $this->assertTrue($result);
  }

  public function test_should_validator_return_true_for_valid_class_with_method_handler()
  {
    $newClass = new class() {
      public function mockedMethod() {}
    };
    $className = [$newClass::class, 'mockedMethod'];

    $result = $this->sut->validate($className);

    $this->assertTrue($result);
  }

  public function test_should_validator_return_true_for_valid_class_with_multiple_methods()
  {
    $newClass = new class() {
      public function mockedMethod() {}
      public function anotherMockedMethod() {}
    };
    $className = [$newClass::class, 'anotherMockedMethod'];

    $result = $this->sut->validate($className);

    $this->assertTrue($result);
  }

  public static function invalidClassNames(): array
  {
    return [
      'classname_is_empty_array' => [
        'className' => [],
        'expectedException' => GivenHandlerClassDoesntExistException::class
      ],
      'classname_is_null' => [
        'className' => null,
        'expectedException' => GivenHandlerClassDoesntExistException::class
      ],
      'classname_is_array_of_empty_strings' => [
        'className' => ['', '', ''],
        'expectedException' => RouteHandlerIsNotAValidClass::class
      ],
      'classname_is_integer' => [
        'className' => 1,
        'expectedException' => RouteHandlerIsNotAValidClass::class
      ],
    ];
  }
}
