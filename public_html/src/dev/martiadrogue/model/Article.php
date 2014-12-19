<?php
namespace dev\martiadrogue\model;

use \DateTime;

class Article {
  private $title;
  private $author;
  private $content;
  private $tags;
  private $created_at;

  public function __construct($id, $title, $author, $content, $tags, DateTime $created_at) {
    $this->id = $id;
    $this->title = $title;
    $this->author = $author;
    $this->content = $content;
    $this->tags = $tags;
    $this->created_at = $created_at;
  }

  public function getId() {
    return $this->id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getAuthor() {
    return $this->author;
  }

  public function getContent() {
    return $this->content;
  }

  public function getTags() {
    return $this->tags;
  }

  public function getCreated_at() {
    return $this->created_at;
  }

  public function __toString() {
    return $title;
  }
}
