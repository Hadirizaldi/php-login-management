<?php

namespace Hadirizaldi\PhpMvc\Models;

use Hadirizaldi\PhpMvc\Exceptions\ValidationException;

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

  // function untuk validation data
  abstract public function validate(): void;

  protected function validateRequiredField(?string $fieldValue, string $fieldName): void
  {
    if ($fieldValue === null || trim($fieldValue) === '') {
      throw new ValidationException("$fieldName field can't be blank!");
    }
  }
}
