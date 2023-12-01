<?php

namespace App\Services\Interfaces;

interface IMethodFinder
{
  public function findMethodInClass(string $className, string $methodName): array;
}