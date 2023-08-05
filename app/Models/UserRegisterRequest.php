<?php

namespace Hadirizaldi\PhpMvc\Models;

class UserRegisterRequest extends UserRequest
{
  private ?string $name;

  public function __construct(string $id, string $name = null, string $password)
  {
    UserRequest::__construct($id, $password);
    $this->name = $name;
  }

  // Getter method
  public function getName(): ?string
  {
    return $this->name;
  }

  public function validate(): void
  {
    $this->validateRequiredField($this->getId(), 'Id');
    $this->validateRequiredField($this->getName(), 'Name');
    $this->validateRequiredField($this->getPassword(), 'Password');
  }
}
