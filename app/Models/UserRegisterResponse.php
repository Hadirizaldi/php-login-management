<?php

namespace Hadirizaldi\PhpMvc\Models;

use Hadirizaldi\PhpMvc\Domain\User;

class UserRegisterResponse
{
  private User $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getUser(): User
  {
    return $this->user;
  }
}
