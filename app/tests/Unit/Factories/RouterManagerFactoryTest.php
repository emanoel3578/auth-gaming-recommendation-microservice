<?php

use App\Bootstrap\Router\HttpRouterManager;
use App\Factories\RouterManagerFactory;
use PHPUnit\Framework\TestCase;

class RouterManagerFactoryTest extends TestCase
{
  public function test_should_factory_return_correct_class_instance()
  {
    $sut = RouterManagerFactory::make();

    $this->assertInstanceOf(HttpRouterManager::class,$sut);
  }
}