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
        'handler' => 'Testing'
      ],
      [
        'method' => 'GET',
        'uri' => '/test-handler',
        'handler' => 'Testing@testing'
      ],
    ];
  }
}