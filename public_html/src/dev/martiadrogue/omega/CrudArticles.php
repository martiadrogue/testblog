<?php
namespace dev\martiadrogue\omega;

use dev\martiadrogue\omega\DataBase;
use dev\martiadrogue\model\Article;

use \PDO;
use \DateTime;

class CrudArticles {

  private $connection;

  public function __construct() {
    $db = new DataBase();
    $this->connection = $db->openConnection();
    $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  }

  public function create($title, $autho, $content, $tags, $creat_at) {
    try {
      $query = "INSERT INTO articles ( title, author, content, tags, created_at ) VALUES ( :title, :autho, :content, :tags, :creat_at )";
      $items = array(':title' => $title, ':autho' => $autho, ':content' => $content, ':tags' => $tags, ':creat_at' => $creat_at);
      $statement = $this->connection->prepare($query);

      return $statement->execute($items);
    }catch(PDOException $ex){ //to handle error
      return false;
    }
  }

  public function read($id = null) {
    try {
      if (isset($id)) {
        return $this->getArticle($id);
      } else {
        return $this->getArticles();
      }
    } catch(PDOException $ex) {
      return false;
    }
  }

  public function update($id, $title, $author, $content, $tags, $created_at) {
    try {
      $query = "UPDATE articles SET title = :title, author = :author, content = :content, tags = :tags, created_at = :created_at WHERE id=:id";
      $statement = $this->connection->prepare($query);
      $statement->bindParam(':id', $id, PDO::PARAM_INT);
      $statement->bindParam(':title', $title, PDO::PARAM_STR);
      $statement->bindParam(':author', $author, PDO::PARAM_STR);
      $statement->bindParam(':content', $content, PDO::PARAM_STR);
      $statement->bindParam(':tags', $tags, PDO::PARAM_STR);
      $statement->bindParam(':created_at', $created_at, PDO::PARAM_INT);
      $result = $statement->execute();
    }catch(PDOException $ex){ //to handle error
    }
  }

  public function delete($id) {
    try {
      $query = 'DELETE FROM `tasks` WHERE id=:id';
      $items = array(':id' => $id);
      $statement = $this->connection->prepare($query);
      $statement->execute($items);
    }catch(PDOException $ex){ //to handle error
    }
  }

  public function getListIncertId() {
    return $this->connection->lastInsertId();
  }

  private function getArticle($id) {

    $query = 'SELECT * FROM articles WHERE id=:id';
    $statement = $this->connection->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $item = $statement->fetch();
    return $item ? $this->formatItem($item) : false;
  }

  private function getArticles() {
    $query = 'SELECT * FROM articles ORDER BY created_at DESC';
    $statement = $this->connection->query($query);
    $items = $statement->fetchAll();

    $articles = $this->formatItems($items);
    return $articles;
  }

  private function formatItems(array $items) {
    $articles = array();
    foreach($items as $item) {
      $articles[] = $this->formatItem($item);
    }
    return $articles;
  }

  private function formatItem(array $item) {
    $date = new DateTime();
    $article = new Article($item['id'],
        $item['title'],
        $item['author'],
        $item['content'],
        $item['tags'],
        $date->setTimestamp(0 + $item['created_at'])
      );
    return $article;
  }

  private function formatTags(&$articles) {
    for($i = 0; $i < count($articles); $i++) {
      $tags = $articles[$i]['tags'];
      $articles[$i]['tags'] = explode(',', $tags);
    }
  }
}
