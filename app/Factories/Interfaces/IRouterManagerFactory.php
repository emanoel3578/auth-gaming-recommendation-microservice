<?php

namespace App\Factories\Interfaces;

use App\Bootstrap\Router\HttpRouterManager;

interface IRouterManagerFactory
{
  public static function make(): HttpRouterManager;
}