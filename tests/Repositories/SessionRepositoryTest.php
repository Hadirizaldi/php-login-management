<?php

namespace Hadirizaldi\PhpMvc\Repositories;

use Hadirizaldi\PhpMvc\Config\Database;
use Hadirizaldi\PhpMvc\Domain\Session;
use Hadirizaldi\PhpMvc\Domain\User;
use PHPUnit\Framework\TestCase;

class SessionRepositoryTest extends TestCase
{
  private SessionRepositoryImpl $sessionRepository;
  private UserRepositoryImpl $userRepository;

  public function setUp(): void
  {
    $this->userRepository = new UserRepositoryImpl(Database::getConnection());
    $this->sessionRepository = new SessionRepositoryImpl(Database::getConnection());

    $this->sessionRepository->deleteAll();
    $this->userRepository->deleteAll();

    // buat user model
    $user = new User('aldi', 'Aldi', 'rahasia');
    $this->userRepository->save($user);
  }

  public function testSaveSuccess()
  {
    $session = new Session(uniqid(), 'aldi');
    $this->sessionRepository->save($session);

    $result = $this->sessionRepository->findById($session->getId());

    self::assertEquals($result->getId(), $session->getId());
    self::assertEquals($result->getUserId(), $session->getUserId());
  }

  public function testDeleteByIdSuccess()
  {
    $session = new Session(uniqid(), 'aldi');
    $this->sessionRepository->save($session);

    $result = $this->sessionRepository->findById($session->getId());
    self::assertEquals($result->getId(), $session->getId());
    self::assertEquals($result->getUserId(), $session->getUserId());

    $this->sessionRepository->deleteById($session->getId());
    $result = $this->sessionRepository->findById($session->getId());
    self::assertNull($result);
  }

  public function testFindByIdNotFound()
  {
    $result = $this->sessionRepository->findById('notfound');
    self::assertNull($result);
  }
}
