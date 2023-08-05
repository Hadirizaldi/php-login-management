<?php

namespace Hadirizaldi\PhpMvc\Repositories;

use Hadirizaldi\PhpMvc\Domain\User;

class UserRepositoryImpl implements UserRepository
{
  private \PDO $connection;

  public function __construct(\PDO $connection)
  {
    $this->connection = $connection;
  }

  public function save(User $user): User
  {
    $sql = "INSERT INTO users (id, name, password) 
            VALUES (:id, :name, :password)";
    $statment = $this->connection->prepare($sql);
    $statment->bindValue(':id', $user->getId());
    $statment->bindValue(':name', $user->getName());
    $statment->bindValue(':password', $user->getPassword());
    $statment->execute();

    return $user;
  }

  public function findByID(string $id): ?User
  {
    $sql = "SELECT id, name, password FROM users 
            WHERE id= :id";
    $statment = $this->connection->prepare($sql);
    $statment->bindParam(':id', $id);
    $statment->execute();

    // $statment->fetchObject(User::class);
    try {

      if ($row = $statment->fetch()) {
        $user = new User($row['id'], $row['name'], $row['password']);

        return $user;
      } else {
        return null;
      }
    } finally {
      $statment->closeCursor();
    }
  }

  public function deleteAll(): bool
  {
    $sql = "DELETE FROM users";
    $statment = $this->connection->prepare($sql);
    $result = $statment->execute();

    return $result;
  }
}
