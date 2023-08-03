<?php

namespace Hadirizaldi\PhpMvc\Repositories;

use Hadirizaldi\PhpMvc\Domain\User;


class UserRepositoryImpl extends UserRepository
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
}
