<?php

use App\Container\Container;
use App\Controllers\TestingController;
use App\Exceptions\NotFoundContainerException;
use App\Validator\Interfaces\IValidator;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
  public function test_it_can_be_instantiated_using_class_const_name()
  {
    $container = new Container();
    
    $instanceResult = $container->get(TestingController::class);

    $this->assertInstanceOf(TestingController::class, $instanceResult);
  }

  public function test_it_throws_exception_if_given_class_name_is_string()
  {
    $container = new Container();
    
    $this->expectException(NotFoundContainerException::class);
    $container->get('TestingController');
  }

  public function test_it_throws_exception_if_given_class_name_is_interface()
  {
    $container = new Container();

    $this->expectException(NotFoundContainerException::class);
    $container->get(IValidator::class);
  }
}