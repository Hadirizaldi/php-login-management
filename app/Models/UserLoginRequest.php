<?php

namespace Hadirizaldi\PhpMvc\Models;

class UserLoginRequest extends UserRequest
{
  public function validate(): void
  {
    $this->validateRequiredField($this->getId(), 'Id');
    $this->validateRequiredField($this->getPassword(), 'Password');
  }
}
