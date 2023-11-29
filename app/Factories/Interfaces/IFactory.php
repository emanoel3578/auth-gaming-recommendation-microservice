<?php

namespace App\Factories\Interfaces;

interface IFactory
{
  public static function make($data = []): mixed;
}