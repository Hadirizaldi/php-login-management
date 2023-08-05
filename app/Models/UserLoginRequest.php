<?php

namespace Hadirizaldi\PhpMvc\Models;

class UserLoginRequest extends UserRequest
{
  public function __construct(string $id = null, string $password = null)
  {
    parent::__construct($id, $password);
  }
}
