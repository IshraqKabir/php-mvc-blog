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
}
