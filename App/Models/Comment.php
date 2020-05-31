<?php

namespace App\Models;
use PDO;



class Comment extends \Core\Model {
  public static function addComment($post_id, $content) {
    try {
      $db = static::getDB();
      $query = 'INSERT INTO comments(user_id, post_id, content) VALUES(:user_id, :post_id, :content)';
      $statement = $db->prepare($query);
      $statement->execute(['user_id' => $_SESSION['user_id'], 'post_id' => $post_id, 'content' => $content]);
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public static function getCommentCount($post_id) {
    try {
      $db = static::getDB();
      $query = 'SELECT * FROM comments WHERE post_id = :post_id';
      $statement = $db->prepare($query);
      $statement->execute(['post_id' => $post_id]);
      $count = $statement->rowCount();
      return $count;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }

  public static function getCommentsOfAPost($post_id) {
      try {
        $db = static::getDB();
        $query = 'SELECT comments.user_id, comments.post_id, comments.content, comments.created_at, users.username
          FROM comments
          JOIN users
          ON comments.user_id = users.user_id
          WHERE comments.post_id = :post_id
          ORDER BY comments.created_at DESC';
      $statement = $db->prepare($query);
      $statement->execute(['post_id'=>$post_id]);
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      // print_r($result);
      return $result;
    }
    catch (PDOException $e) {
      echo $e->getMessage();
    }
  }
}
