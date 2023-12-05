<?php

namespace App\Services\Interfaces;

interface IHandlerExtractorService
{
  public function extractHandlerData(string $handler): array;
}