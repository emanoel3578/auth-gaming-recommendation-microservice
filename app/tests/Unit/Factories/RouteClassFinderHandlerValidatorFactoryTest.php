<?php

use App\Factories\RouteClassFinderHandlerValidatorFactory;
use App\Validator\RouterValidators\RouteClassFinderHandlerValidator;
use PHPUnit\Framework\TestCase;

class RouteClassFinderHandlerValidatorFactoryTest extends TestCase
{
  public function test_should_factory_return_correct_class_instance()
  {
    $sut = RouteClassFinderHandlerValidatorFactory::make();

    $this->assertInstanceOf(RouteClassFinderHandlerValidator::class,$sut);
  }
}