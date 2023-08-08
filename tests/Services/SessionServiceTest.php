<?php

namespace Hadirizaldi\PhpMvc\Services;

use Hadirizaldi\PhpMvc\Config\Database;
use Hadirizaldi\PhpMvc\Domain\User;
use Hadirizaldi\PhpMvc\Domain\Session;
use Hadirizaldi\PhpMvc\Repositories\SessionRepositoryImpl;
use Hadirizaldi\PhpMvc\Repositories\UserRepositoryImpl;
use Hadirizaldi\PhpMvc\Services\SessionServiceImpl;
use PHPUnit\Framework\TestCase;

class SessionServiceTest extends TestCase
{
  private SessionRepositoryImpl $sessionRepository;
  private UserRepositoryImpl $userRepository;
  private SessionServiceImpl $sessionService;

  public function setUp(): void
  {
    $this->userRepository = new UserRepositoryImpl(Database::getConnection());
    $this->sessionRepository = new SessionRepositoryImpl(Database::getConnection());
    $this->sessionService = new SessionServiceImpl($this->sessionRepository, $this->userRepository);

    $this->sessionRepository->deleteAll();
    $this->userRepository->deleteAll();

    // dummy user
    $user = new User('aldi', 'Aldi', 'rahasia');
    $this->userRepository->save($user);
  }

  public function testCreate()
  {
    $session = $this->sessionService->create('aldi');
    $sessionId = $session->getId();

    // $this->expectOutputRegex("[X-ABECE-SESSION: $sessionId]");

    $result = $this->sessionRepository->findById($sessionId);
    self::assertEquals("aldi", $result->getUserId());
  }

  public function testDestroy()
  {
    $session = new Session(uniqid(), 'aldi');
    $this->sessionRepository->save($session);

    $_COOKIE[SessionServiceImpl::$COOKIE_NAME] = $session->getId();

    $this->sessionService->destroy();
    $result = $this->sessionRepository->findById($session->getId());
    self::assertNull($result);
  }

  public function testCurrent()
  {
    $session = new Session(uniqid(), 'aldi');
    $this->sessionRepository->save($session);

    $_COOKIE[SessionServiceImpl::$COOKIE_NAME] = $session->getId();
    $user = $this->sessionService->current();

    self::assertEquals($session->getUserId(), $user->getId());
  }
}
