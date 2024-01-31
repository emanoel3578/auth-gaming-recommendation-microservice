<?php

use App\Config\DatabaseConfigSingleton;
use App\Database\DatabaseConnectorSingleton;
use App\Repositories\UserRepository;
use PHPUnit\Framework\TestCase;

class RegisterUserTest extends TestCase
{
  private UserRepository $sut;
  private DatabaseConnectorSingleton $databaseConnection;

  protected function setUp(): void
  {
    parent::setUp();
    $configuration = DatabaseConfigSingleton::getInstance('testing');
    $this->databaseConnection = DatabaseConnectorSingleton::getInstance($configuration);
    $this->sut = new UserRepository($this->databaseConnection);
  }

  protected function tearDown(): void
  {
    parent::tearDown();
    $this->databaseConnection->destroy();
  }

  public function test_should_return_true_user_register_using_email_and_password()
  {
    $userEmail = 'test@test.com';
    $userPassword = 'password-123';

    $resultRegister = $this->sut->register($userEmail, $userPassword);

    $sql = 'SELECT * FROM users as u WHERE u.user_id = (SELECT max(user_id) FROM users)';
    $lastInsert = $this->databaseConnection->getConnection()->query($sql)->fetch(PDO::FETCH_ASSOC);
    
    $this->assertTrue($resultRegister);
    $this->assertEquals($userEmail, $lastInsert['email']);
    $this->assertEquals($userPassword, $lastInsert['password']);
  }

  public function test_should_find_user_by_email()
  {
    $userEmail = 'test@test.com';
  }
}
