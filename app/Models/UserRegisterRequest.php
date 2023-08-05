<?php

namespace Hadirizaldi\PhpMvc\Models;

class UserRegisterRequest extends UserRequest
{
  private ?string $name;

  public function __construct(string $id = null, string $name = null, string $password = null)
  {
    UserRequest::__construct($id, $password);
    $this->name = $name;
  }

  // Getter method
  public function getName(): ?string
  {
    return $this->name;
  }
}
