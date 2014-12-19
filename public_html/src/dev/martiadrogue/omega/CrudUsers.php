<?php
namespace dev\martiadrogue\omega;

use dev\martiadrogue\omega\DataBase;
use \PDO;

class CrudUsers {

  private $connection;

  public function __construct() {
    $db = new DataBase();
    $this->connection = $db->openConnection();
    $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }

  public function read($name) {
    try {
      return $this->getUser($name);
    } catch(PDOException $ex) {
      return false;
    }
  }

  private function getUser($name) {
    $query = 'SELECT id, name, password FROM users WHERE name=:name';
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();
    return $statement->fetch();
  }
}
