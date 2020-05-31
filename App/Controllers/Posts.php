<?php
namespace App\Controllers;

use Core\View;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class Posts {
  public $name = 'posts';

  public function allPosts() {
    $allPosts = Post::getAllPosts();
    $user = User::getUserByID($_SESSION['user_id']);



    for ($i = 0; $i < count($allPosts); $i++) {
      $didCurrentUserLikeThePost = Post::checkIfCurrentUserLikedThePost($allPosts[$i]['id']);
      $likeCount = Post::getLikeCount($allPosts[$i]['id']);
      $commentCount = Comment::getCommentCount($allPosts[$i]['id']);

      $allPosts[$i]['didCurrentUserLikeThePost'] = $didCurrentUserLikeThePost;
      if ($didCurrentUserLikeThePost) {
        $allPosts[$i]['didCurrentUserLikeThePost'] = 1;
      } else {
        $allPosts[$i]['didCurrentUserLikeThePost'] = 0;
      }
      $allPosts[$i]['likeCount'] = $likeCount;
      $allPosts[$i]['commentCount'] = $commentCount;


      $comments = Comment::getCommentsOfAPost($allPosts[$i]['id']);

      $allPosts[$i]['comments'] = $comments;
    }


    // print_r($allPosts);
    $args = array(
      "allPosts" => $allPosts
    );
    View::renderTemplate('Posts/allPosts.html', $args);
  }

  public function addPost() {
    $args = [
      'title_error' => '',
      'content_error' => ''
    ];
    if(count($_POST) > 0) {
      if ($_POST['title'] == '' || $_POST['content'] == '') {
        if ($_POST['title'] == '') {
          $args['title_error'] = 'title cannot be empty';
        }
        if ($_POST['content'] == '') {
          $args['content_error'] = 'content cannot be empty';
        }
      } else {
        Post::addPost($_POST['title'], $_POST['content']);
        header("LOCATION: http://localhost/posts/allPosts");
      }
    }
    View::renderTemplate('Posts/addPost.html', $args);
  }

  public function singlePost($id) {
    echo "showing post $id";
  }

  public function deletePost($post_id) {
    $post = Post::getSinglePost($post_id);
    if ($post['user_id'] != $_SESSION['user_id']) {
      header("Refresh:0; url=http://localhost/users/logout");
      return;
    }
    Post::deletePost($post_id);
    header("Refresh:0; url=http://localhost/posts/allPosts");
  }

  public function editPost($post_id) {
    $post = Post::getSinglePost($post_id);
    if ($post['user_id'] != $_SESSION['user_id']) {
      header("Refresh:0; url=http://localhost/users/logout");
      return;
    }
    $args = [
      'post_content' => $post['content'],
      'post_title' => $post['title'],
      'post_id' => $post['id'],
      'title_error' => '',
      'content_error' => ''
    ];
    if(count($_POST) > 0) {
      if ($_POST['title'] == '' || $_POST['content'] == '') {
        if ($_POST['title'] == '') {
          $args['title_error'] = 'title cannot be empty';
        }
        if ($_POST['content'] == '') {
          $args['content_error'] = 'content cannot be empty';
        }
      } else {
        Post::editPost($post_id, $_POST['title'], $_POST['content']);
        header("LOCATION: http://localhost/posts/allPosts");
      }
    }
    View::renderTemplate('Posts/editPost.html', $args);
  }

  public function likePost($post_id) {
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    // if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    //   return;
    // }
    echo 'reached the controller';
    $user_id = $_SESSION['user_id'];
    Post::likePost($post_id, $user_id);
  }
}
