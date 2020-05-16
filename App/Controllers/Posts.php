<?php
namespace App\Controllers;

use Core\View;
use App\Models\Post;
use App\Models\User;

class Posts {
  public $name = 'posts';

  public function allPosts() {
    $allPosts = Post::getAllPosts();
    $user = User::getUserByID($_SESSION['user_id']);
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
    Post::deletePost($post_id);
    header("Refresh:0; url=http://localhost/posts/allPosts");
  }

  public function editPost($post_id) {
    $post = Post::getSinglePost($post_id);
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
        echo 'edit from con';
        Post::editPost($post_id, $_POST['title'], $_POST['content']);
        header("LOCATION: http://localhost/posts/allPosts");
      }
    }
    View::renderTemplate('Posts/editPost.html', $args);
  }
}
