<?php

use App\Config\DatabaseConfigSingleton;
use App\Database\DatabaseConnectorSingleton;
use App\Exceptions\Database\DatabaseConnectionException;
use PHPUnit\Framework\TestCase;

class SetupDatabaseTest extends TestCase
{
  public function test_should_database_connector_return_valid_connection_to_configured_database()
  {
    $configuration = DatabaseConfigSingleton::getInstance('testing');
    $sut = DatabaseConnectorSingleton::getInstance($configuration);

    $connectionResult = $sut->getConnection();

    $this->assertInstanceOf(PDO::class, $connectionResult);

    $configuration->destroy();
    $sut->destroy();
  }

  public function test_should_database_connector_throw_exception_if_invalid_credentials_are_given()
  {
    $incorretConfiguration = [
      'host' => '123',
      'port' => '123',
      'database' => 'not-found',
      'username' => '',
      'password' => ''
    ];

    $mockedConfiguration = $this->createMock(DatabaseConfigSingleton::class);
    $mockedConfiguration->method('getConfiguration')->willReturn($incorretConfiguration);
    $this->expectException(DatabaseConnectionException::class);
    $sut = DatabaseConnectorSingleton::getInstance($mockedConfiguration);
    $sut->getConnection();

    $sut->destroy();
  }
}
