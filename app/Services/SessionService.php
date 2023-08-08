<?php

namespace Hadirizaldi\PhpMvc\Services;

use Hadirizaldi\PhpMvc\Domain\Session;
use Hadirizaldi\PhpMvc\Domain\User;

interface SessionService
{
  public function create(string $userId): Session;
  // destroy memakai detect season saat ini
  public function destroy(): void;
  public function current(): ?User;
}
