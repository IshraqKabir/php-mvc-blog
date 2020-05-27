<?php
namespace App\Controllers;

use Core\View;
use App\Models\Post;
use App\Models\User;

class Profiles {
  public function userProfile($user_id) {
    $user = User::getUserByID($user_id);
    $allPosts = Post::getPostByUserID($user_id);

    for ($i = 0; $i < count($allPosts); $i++) {
      $didCurrentUserLikeThePost = Post::checkIfCurrentUserLikedThePost($allPosts[$i]['id']);
      $likeCount = Post::getLikeCount($allPosts[$i]['id']);

      $allPosts[$i]['didCurrentUserLikeThePost'] = $didCurrentUserLikeThePost;
      if ($didCurrentUserLikeThePost) {
        $allPosts[$i]['didCurrentUserLikeThePost'] = 1;
      } else {
        $allPosts[$i]['didCurrentUserLikeThePost'] = 0;
      }
      $allPosts[$i]['likeCount'] = $likeCount;
    }

    $args = [
      'user' => $user,
      'allPosts' => $allPosts,
    ];
    View::renderTemplate('Profiles/profile.html', $args);
  }
}
