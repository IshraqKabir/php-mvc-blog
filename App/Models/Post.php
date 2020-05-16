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

  public static function getSinglePost($post_id) {
    try {
      $db = static::getDB();
      $query = 'SELECT * FROM posts WHERE id = :post_id';
      $statement = $db->prepare($query);
      $statement->execute(['post_id' => $post_id]);
      $post = $statement->fetch(PDO::FETCH_ASSOC);
      return $post;
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

  public static function editPost($post_id, $post_title, $post_content) {
    try {
      $db = static::getDB();
      $query = 'UPDATE posts SET title = ?, content = ? WHERE id = ?';
      $statement = $db->prepare($query);
      $statement->execute([$post_title, $post_content, $post_id]);
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
