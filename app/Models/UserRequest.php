<?php

namespace Hadirizaldi\PhpMvc\Models;

abstract class UserRequest
{
  protected ?string $id;
  protected ?string $password;

  public function __construct(string $id = null, string $password = null)
  {
    $this->id = $id;
    $this->password = $password;
  }

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
