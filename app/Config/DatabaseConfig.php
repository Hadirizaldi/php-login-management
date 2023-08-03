<?php

namespace Hadirizaldi\PhpMvc\Config;

class DatabaseConfig implements DatabaseConfigInterface
{
  public function getDatabaseConfig(): array
  {
    return [
      "database" => [
        "test" => [
          "url" => "mysql:host=localhost:3306;dbname=php_login_management_test",
          "username" => "megatron",
          "password" => "Megatron-111213"
        ],
        "prod" => [
          "url" => "mysql:host=localhost:3306;dbname=php_login_management",
          "username" => "megatron",
          "password" => "Megatron-111213"
        ]
      ]
    ];
  }
}
