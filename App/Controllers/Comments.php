<?php
namespace App\Controllers;

use Core\View;
use App\Models\Comment;
use App\Models\User;

class Comments {
  public function addComment() {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    $data = json_decode(file_get_contents("php://input"));



    $post_id = $data->post_id;
    $content = $data->content;

    Comment::addComment($post_id, $content);


  }
}
