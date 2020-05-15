<?php

namespace App\Models;
use PDO;

class Post extends \Core\Model {
  public static function getAllPosts() {
    try {
      $db = static::getDB();
      $query = 'SELECT id, title, content, user_id FROM posts ORDER BY -created_at';
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
      $query = 'INSERT INTO posts(title, content, user_id) VALUES(:title, :content, :user_id)';
      $statement = $db->prepare($query);
      $statement->execute(['title' => $title, 'content' => $content, 'user_id' => $_SESSION['user_id']]);
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
