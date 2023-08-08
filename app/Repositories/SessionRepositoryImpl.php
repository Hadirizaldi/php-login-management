<?php

namespace Hadirizaldi\PhpMvc\Repositories;

use Hadirizaldi\PhpMvc\Domain\Session;

class SessionRepositoryImpl implements SessionRepository
{
  private \PDO $connection;

  public function __construct(\PDO $connection)
  {
    $this->connection = $connection;
  }

  public function save(Session $session): Session
  {
    $sql = "INSERT INTO sessions (id, user_id) 
            VALUES(:id, :user_id)";
    $statment = $this->connection->prepare($sql);
    $statment->bindValue(':id', $session->getId());
    $statment->bindValue(':user_id', $session->getUserId());
    $statment->execute();

    return $session;
  }

  public function findById(string $id): ?Session
  {
    $sql = "SELECT id, user_id FROM sessions 
            WHERE id = :id";
    $statment = $this->connection->prepare($sql);
    $statment->bindParam(':id', $id);
    $statment->execute();

    try {
      if ($row = $statment->fetch()) {
        $session = new Session($row['id'], $row['user_id']);
        return $session;
      } else {
        return null;
      }
    } finally {
      $statment->closeCursor();
    }
  }
  public function deleteByid(string $id): void
  {
    $sql = "DELETE FROM sessions WHERE id = :id";
    $statment = $this->connection->prepare($sql);
    $statment->bindParam(':id', $id);
    $statment->execute();
  }

  public function deleteAll(): void
  {
    $sql = "DELETE FROM sessions";
    $statment = $this->connection->prepare($sql);
    $statment->execute();
  }
}
