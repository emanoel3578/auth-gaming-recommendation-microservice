<?php

namespace App\Routes\Api;

use App\Controllers\TestingController;

class DeclaredRoutes
{
  public function getRoutes(): array
  {
    return [
      [
        'method' => 'GET',
        'uri' => '/test',
        'handler' => [TestingController::class]
      ],
      [
        'method' => 'GET',
        'uri' => '/test-handler',
        'handler' => [TestingController::class, 'callHandler']
      ],
    ];
  }
}