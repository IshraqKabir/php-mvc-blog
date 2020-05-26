<?php
namespace App\Controllers;

use Core\View;
use App\Models\Post;
use App\Models\User;

class Profiles {
  public function userProfile($user_id) {
    $user = User::getUserByID($user_id);
    $posts_by_user = Post::getPostByUserID($user_id);
    $args = [
      'user' => $user,
      'posts_by_user' => $posts_by_user,
    ];
    View::renderTemplate('Profiles/profile.html', $args);
  }
}
