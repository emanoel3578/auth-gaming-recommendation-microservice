<?php

namespace App\Formatters\Router;

use App\Formatters\Interfaces\IFormatter;

class RouteDispatchedInfoFormatter implements IFormatter
{
  private const STATUS_INDEX = 0;
  private const PARAMETERS_INDEX = 3;
  public const CLASS_NAME_INDEX = 0;
  public const METHOD_NAME_INDEX = 1;
  public const STATUS_INDEX_FORMATTED = 'status';
  public const CLASS_NAME_HANDLER_INDEX_FORMATTED = 'handler';
  public const METHOD_HANDLER_INDEX_FORMATTED = 'method_handler';
  public const PARAMETERS_INDEX_FORMATTED = 'parameters';

  public function format(mixed $dispachedRouteInfoArr): mixed
  {
    $handlerArr = explode('@', $dispachedRouteInfoArr[self::METHOD_NAME_INDEX]);
    $methodHandler = '';

    if (!empty($handlerArr[self::METHOD_NAME_INDEX])) {
      $methodHandler = $handlerArr[self::METHOD_NAME_INDEX];
    }

    return [
      self::STATUS_INDEX_FORMATTED => $dispachedRouteInfoArr[self::STATUS_INDEX],
      self::CLASS_NAME_HANDLER_INDEX_FORMATTED =>$handlerArr[self::CLASS_NAME_INDEX],
      self::METHOD_HANDLER_INDEX_FORMATTED => $methodHandler,
      self::PARAMETERS_INDEX_FORMATTED => !empty($dispachedRouteInfoArr[self::PARAMETERS_INDEX])
      ? [$dispachedRouteInfoArr[self::PARAMETERS_INDEX]] : []
    ];
  }
}