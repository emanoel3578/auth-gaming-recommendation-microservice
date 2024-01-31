<?php

namespace App\Database;

use App\Config\DatabaseConfigSingleton;
use App\Exceptions\Database\DatabaseConnectionException;
use PDO;

class DatabaseConnectorSingleton
{
  private static $instances = [];
  protected PDO $connection;

  protected function __construct(protected DatabaseConfigSingleton $databaseConfig)
  {
    $this->createConnection();
  }

  public static function getInstance(?DatabaseConfigSingleton $databaseConfig = null): self
  {
    $singleInstance = self::class;
    if (!isset(self::$instances[$singleInstance])) {
      $databaseConfig = $databaseConfig ?? DatabaseConfigSingleton::getInstance();
      return self::$instances[] = new static($databaseConfig);
    }

    return self::$instances[$singleInstance];
  }

  public static function destroy(): void
  {
    self::$instances = [];
  }

  private function createConnection(): void
  {
    try {
      $configuration = $this->databaseConfig->getConfiguration();
  
      $dns = 'mysql:host=' .
      $configuration['host'] .
      ';port=' .
      $configuration['port'] .
      ';dbname='.
      $configuration['database'] .
      ';charset=UTF8';
      
      $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
      $this->connection = new PDO($dns, $configuration['username'], $configuration['password'], $options);
    } catch (\Throwable $th) {
      throw new DatabaseConnectionException;
    }
  }

  public function getConnection(): PDO
  {
    return $this->connection;
  }
}