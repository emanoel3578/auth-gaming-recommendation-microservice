<?php

namespace App\Bootstrap;

use App\Bootstrap\Interfaces\IHttpRouterManager;

class App
{
  public function __construct(IHttpRouterManager $httpRouterManager)
  {
    $httpRouterManager->handleRouting();
  }
}
