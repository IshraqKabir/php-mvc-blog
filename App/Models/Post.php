<?php

namespace App\Models;
use PDO;

class Post extends \Core\Model {
  public static function getAllPosts() {
    try {
      $db = static::getDB();
      $query = 'SELECT id, title, content, user_id, user_username FROM posts ORDER BY -created_at';
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
      $query = 'INSERT INTO posts(title, content, user_id, user_username) VALUES(:title, :content, :user_id, :user_username)';
      $statement = $db->prepare($query);
      $statement->execute(['title' => $title, 'content' => $content, 'user_id' => $_SESSION['user_id'], 'user_username' => $_SESSION['username']]);
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public static function deletePost($post_id) {
    try {
      $db = static::getDB();
      $query = 'DELETE FROM posts WHERE id = :id';
      $statement = $db->prepare($query);
      $statement->execute(['id' => $post_id]);
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
