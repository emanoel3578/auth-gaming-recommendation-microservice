<?php

use App\Bootstrap\RouterResolver;
use App\Factories\RouterResolverFactory;
use PHPUnit\Framework\TestCase;

class RouterResolverFactoryTest extends TestCase
{
  public function test_should_factory_return_correct_class_instance()
  {
    $sut = RouterResolverFactory::make();

    $this->assertInstanceOf(RouterResolver::class,$sut);
  }
}