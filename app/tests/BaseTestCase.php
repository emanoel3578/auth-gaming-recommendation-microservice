<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

abstract class BaseTestCase extends TestCase
{
  protected ClientInterface $httpRequestClient;
  
  public function __construct($httpRequestClient)
  {
    $this->httpRequestClient = new Client();
  }

  public function sendHttpRequest(string $method, string $uri, string $queryParameters = '')
  {
    // Implements later
    return;
  }
}