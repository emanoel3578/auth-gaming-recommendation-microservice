<?php

namespace App\Routes\Api;

class Routes
{
  public function getRoutes(): array
  {
    return [
      [
        'method' => 'GET',
        'uri' => '/test',
        'handler' => 'TestingController'
      ],
      [
        'method' => 'GET',
        'uri' => '/test-handler',
        'handler' => 'TestingController@callHandler'
      ],
    ];
  }
}