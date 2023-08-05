<?php

namespace Hadirizaldi\PhpMvc\Models;

use Hadirizaldi\PhpMvc\Domain\User;

abstract class UserResponse
{
  protected User $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  // get method
  public function getUser(): User
  {
    return $this->user;
  }
}
