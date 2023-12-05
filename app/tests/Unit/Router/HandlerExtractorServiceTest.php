<?php

use PHPUnit\Framework\TestCase;
use App\Services\Route\HandlerExtractorService;

class HandlerExtractorServiceTest extends TestCase
{
  protected $sut;
  protected function setUp(): void
  {
    parent::setUp();
    $this->sut = new HandlerExtractorService;
  }

  public function test_should_return_handler_extracted_without_method_handler_given()
  {
    $handler = 'foundClassName';
    $extractedResult = $this->sut->extractHandlerData($handler);
    $expected = [
      'className' => $handler
    ];

    $this->assertEquals($expected, $extractedResult);
  }

  public function test_should_return_handler_extracted_with_method_handler_given()
  {
    $className = 'foundClassName';
    $methodName = 'foundMethodName';
    $handler = $className . '@' . $methodName;

    $extractedResult = $this->sut->extractHandlerData($handler);

    $expected = [
      'className' => $className,
      'method' => $methodName
    ];

    $this->assertEquals($expected, $extractedResult);
  }
}