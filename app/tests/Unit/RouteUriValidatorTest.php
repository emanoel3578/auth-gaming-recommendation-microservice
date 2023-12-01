<?php

use App\Exceptions\RouteUriCannotBeEmptyException;
use App\Exceptions\RouteUriHasInvalidCharacters;
use App\Exceptions\RouteUriIsHasInvalidTypeException;
use App\Validator\RouterValidators\RouteUriValidator;
use PHPUnit\Framework\TestCase;

class RouteUriValidatorTest extends TestCase
{
  private RouteUriValidator $sut;

  protected function setUp(): void
  {
    parent::setUp();
    $this->sut = new RouteUriValidator;
  }

  /**
   * @dataProvider invalidTypes
   */
  public function test_should_throw_exception_if_uri_is_invalid_type($invalidTypeUri, $exceptionExpected)
  {
    $this->expectException($exceptionExpected);
    $this->sut->validate($invalidTypeUri);
  }

  public function test_should_return_true_for_valid_uri_without_foward_slash()
  {
    $result = $this->sut->validate('test');
    $this->assertTrue($result);
  }

  public function test_should_return_true_for_valid_uri_with_foward_slash()
  {
    $result = $this->sut->validate('/test');
    $this->assertTrue($result);
  }

  public function test_should_return_true_for_valid_uri_with_multiple_foward_slash()
  {
    $result = $this->sut->validate('/test/intern/nested');
    $this->assertTrue($result);
  }

  public static function invalidTypes(): array
  {
    return [
      'uri_type_array' => [
        'invalidTypeUri' => [],
        'exceptionExpected' => RouteUriCannotBeEmptyException::class
      ],
      'uri_type_int' => [
        'invalidTypeUri' => 1,
        'exceptionExpected' => RouteUriIsHasInvalidTypeException::class
      ],
      'uri_type_string_empty' => [
        'invalidTypeUri' => '',
        'exceptionExpected' => RouteUriCannotBeEmptyException::class
      ],
      'uri_type_string_with_blank_space' => [
        'invalidTypeUri' => ' ',
        'exceptionExpected' => RouteUriIsHasInvalidTypeException::class
      ],
      'uri_has_invalid_character' => [
        'invalidTypeUri' => '²test__@(',
        'exceptionExpected' => RouteUriHasInvalidCharacters::class
      ],
    ];
  }
}