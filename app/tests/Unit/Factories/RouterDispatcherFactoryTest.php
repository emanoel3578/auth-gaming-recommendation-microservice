<?php

use App\Bootstrap\Router\RouterDispatcher;
use App\Factories\RouterDispatcherFactory;
use PHPUnit\Framework\TestCase;

class RouterDispatcherFactoryTest extends TestCase
{
  public function test_should_factory_return_correct_class_instance()
  {
    $sut = RouterDispatcherFactory::make();

    $this->assertInstanceOf(RouterDispatcher::class,$sut);
  }
}