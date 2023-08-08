<?php

namespace Hadirizaldi\PhpMvc\Services;

use Hadirizaldi\PhpMvc\Domain\Session;
use Hadirizaldi\PhpMvc\Domain\User;
use Hadirizaldi\PhpMvc\Repositories\SessionRepository;
use Hadirizaldi\PhpMvc\Repositories\UserRepository;

class SessionServiceImpl implements SessionService
{

  public static string $COOKIE_NAME = "X-ABECE-SESSION";
  private SessionRepository $sessionRepository;
  private UserRepository $userRepository;

  public function __construct(SessionRepository $sessionRepository, UserRepository $userRepository)
  {
    $this->sessionRepository = $sessionRepository;
    $this->userRepository = $userRepository;
  }


  public function create(string $userId): Session
  {
    $session = new Session(uniqid(), $userId);
    $this->sessionRepository->save($session);

    // jika berhasil save, maka buat cookie,(1 jam)
    setcookie(self::$COOKIE_NAME, $session->getId(), time() + (60 * 60), '/');

    return $session;
  }

  public function destroy(): void
  {
    $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

    $this->sessionRepository->deleteByid($sessionId);

    // setelah delete, maka buat cookie menjadi expire
    setcookie(self::$COOKIE_NAME, '', 1, '/');
  }

  public function current(): ?User
  {
    $sessionId = $_COOKIE[self::$COOKIE_NAME] ?? '';

    $session = $this->sessionRepository->findById($sessionId);
    if ($session == null) {
      return null;
    }

    // jika ada maka hubungkan ke userRepository
    return $this->userRepository->findById($session->getUserId());
  }
}
