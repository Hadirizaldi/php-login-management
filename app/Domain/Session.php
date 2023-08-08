<?php

namespace Hadirizaldi\PhpMvc\Domain;

class Session
{
  private ?string $id;
  private ?string $user_id;

  public function __construct(string $id, string $user_id)
  {
    $this->id = $id;
    $this->user_id = $user_id;
  }

  // function getter
  public function getId(): string
  {
    return $this->id;
  }

  public function getUserId(): string
  {
    return $this->user_id;
  }
}
