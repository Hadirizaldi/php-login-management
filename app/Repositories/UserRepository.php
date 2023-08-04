<?php

namespace Hadirizaldi\PhpMvc\Repositories;

use Hadirizaldi\PhpMvc\Domain\User;

interface UserRepository
{
  public function save(User $user): User;
  public function findById(string $id): ?User;
  public function deleteAll(): bool;
}
