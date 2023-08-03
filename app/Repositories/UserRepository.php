<?php

namespace Hadirizaldi\PhpMvc\Repositories;

use Hadirizaldi\PhpMvc\Domain\User;

interface UserRepository
{
  public function save(): User;
}
