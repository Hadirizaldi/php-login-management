<?php

namespace Hadirizaldi\PhpMvc\Services;

use Hadirizaldi\PhpMvc\Models\UserRegisterRequest;
use Hadirizaldi\PhpMvc\Models\UserRegisterResponse;

interface UserService
{

  public function register(UserRegisterRequest $userRegisterRequest): UserRegisterResponse;
}
