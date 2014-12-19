<?php
namespace dev\martiadrogue\omega;

use \PDO;

class DataBase {
  private $driver;
  private $host;
  private $dbname;
  private $charset;
  private $username;
  private $password;

  private $connection;

  public function __construct() {
    $config = parse_ini_file('../config/omega.ini');
    $this->driver = $config['driver'];
    $this->host = $config['host'];
    $this->dbname = $config['dbname'];
    $this->charset = $config['charset'];
    $this->username = $config['username'];
    $this->password = $config['password'];
  }

  public function openConnection() {
    if (!$this->connection) {
      try {
        $this->connection = $this->connecting();
      } catch(PDOException $ex) {
      }
    }
    return $this->connection;
  }

  private function connecting() {
    $dsn = $this->buildDsn();
    return new PDO($dsn, $this->username, $this->password);
  }

  private function buildDsn() {
    return "$this->driver:host=$this->host;dbname=$this->dbname;charset=$this->charset";
  }
}
