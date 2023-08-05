<?php

namespace Hadirizaldi\PhpMvc\Models;

abstract class UserRequest
{
  protected ?string $id;
  protected ?string $password;

  // get method
  public function getId(): ?string
  {
    return $this->id;
  }

  public function getPassword(): ?string
  {
    return $this->password;
  }
}
