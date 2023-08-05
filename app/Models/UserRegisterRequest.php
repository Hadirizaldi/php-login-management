<?php

namespace Hadirizaldi\PhpMvc\Models;

class UserRegisterRequest
{
  private ?string $id;
  private ?string $name;
  private ?string $password;

  public function __construct(string $id = null, string $name = null, string $password = null)
  {
    $this->id = $id;
    $this->name = $name;
    $this->password = $password;
  }

  // Getter methods
  public function getId(): string
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getPassword(): string
  {
    return $this->password;
  }
}
