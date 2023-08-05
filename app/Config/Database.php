<?php

namespace Hadirizaldi\PhpMvc\Config;

class Database
{
  private static ?\PDO $connection = null;

  public static function getConnection($env = "test"): \PDO
  {

    if (self::$connection === null) {
      // TODO : create connection
      self::$connection = self::createConnection($env);
    }

    return self::$connection;
  }

  // config database
  private static function getDatabaseConfig(): array
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

  private static function createConnection($env = "test"): \PDO
  {
    $config = self::getDatabaseConfig();

    try {
      $dsn = $config["database"][$env]["url"];
      $username = $config["database"][$env]["username"];
      $password = $config["database"][$env]["password"];

      $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
      ];

      $connection = new \PDO($dsn, $username, $password, $options);

      return $connection;
    } catch (\PDOException $e) {
      die("Kesalahan koneksi database: " . $e->getMessage());
    }
  }

  public static function beginTransaction(): void
  {
    self::$connection->beginTransaction();
  }

  public static function commitTransaction(): void
  {
    self::$connection->commit();
  }

  public static function rollbackTransaction(): void
  {
    self::$connection->rollBack();
  }
}
