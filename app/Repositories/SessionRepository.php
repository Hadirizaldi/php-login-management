<?php

namespace Hadirizaldi\PhpMvc\Repositories;

use Hadirizaldi\PhpMvc\Domain\Session;

interface SessionRepository
{
  public function save(Session $session): Session;
  public function findById(string $id): ?Session;
  public function deleteByid(string $id): void;
  public function deleteAll(): void;
}
