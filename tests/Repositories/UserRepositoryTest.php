<?php

namespace Hadirizaldi\PhpMvc\Repositories;

use Hadirizaldi\PhpMvc\Config\Database;
use Hadirizaldi\PhpMvc\Domain\User;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class UserRepositoryTest extends TestCase
{
  private UserRepositoryImpl $UserRepository;

  public function setUp(): void
  {
    $this->UserRepository = new UserRepositoryImpl(Database::getConnection());
    $this->UserRepository->deleteAll();

    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
      throw new RuntimeException($errstr . " on line " . $errline . " in file " . $errfile);
    });
  }

  public function testSaveSuccess()
  {
    $user = new User('aldi', 'aldi', '111213');

    // save user
    $this->UserRepository->save($user);

    // find user byId
    $result = $this->UserRepository->findById($user->getId());
    // compare
    self::assertEquals($user->getId(), $result->getId());
    self::assertEquals($user->getName(), $result->getName());
    self::assertEquals($user->getPassword(), $result->getPassword());
  }

  public function testFindByIdNotFound()
  {
    $user = $this->UserRepository->findByID("notfound");
    self::assertNull($user);
  }

  public function tearDown(): void
  {
    restore_error_handler();
  }
}
