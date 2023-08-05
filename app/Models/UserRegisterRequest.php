<?php

namespace Hadirizaldi\PhpMvc\Models;

class UserRegisterRequest extends UserRequest
{
  private ?string $name;

  public function __construct(string $id = null, string $name = null, string $password = null)
  {
    $this->id = $id;
    $this->name = $name;
    $this->password = $password;
  }

  // Getter method
  public function getName(): ?string
  {
    return $this->name;
  }
}
