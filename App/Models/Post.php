<?php

namespace App\Models;
use PDO;

class Post extends \Core\Model {
  public static function getAllPosts() {
    try {
      $db = static::getDB();
      $query = 'SELECT id, title, content FROM posts ORDER BY -created_at';
      $statement = $db->query($query);
      $results = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $results;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public static function addPost($title, $content) {
    try {
      $db = static::getDB();
      $query = 'INSERT INTO posts(title, content) VALUES(:title, :content)';
      $statement = $db->prepare($query);
      $statement->execute(['title' => $title, 'content' => $content]);
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
