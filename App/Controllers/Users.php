<?php
namespace App\Controllers;
use Core\View;
use App\Models\User;

class Users {
  public function register() {
    $args = [
      'first_name_error' => '',
      'last_name_error' => '',
      'username_error' => '',
      'email_error' => '',
      'password1_error' => '',
      'password2_error' => '',
    ];
    if (isset($_POST['submit']))
    {
      $args['first_name'] = $_POST['first_name'];
      $args['last_name'] = $_POST['last_name'];
      $args['username'] = $_POST['username'];
      $args['email'] = $_POST['email'];
      $illegal = "#$%^&*()+=-[]';,./{}|:<>?~";
      if ($_POST['first_name'] == '' ||
        $_POST['last_name'] == '' ||
        $_POST['username'] == '' ||
        $_POST['email'] == '' ||
        $_POST['password1'] == '' ||
        $_POST['password2'] == ''
      ) { // only checks if fields are empty
        // and checks if passwords match
        // does not validate username or email
        // to see if duplicate exist
        if ($_POST['first_name'] == '') {
          $args['first_name_error'] = 'First name cannot be empty';
        }
        if ($_POST['last_name'] == '') {
          $args['last_name_error'] = 'Last name cannot be empty';
        }

        if ($_POST['username'] == '') {
          $args['username_error'] = 'Username cannot be empty';
        }
        if ($_POST['email'] == '') {
          $args['email_error'] = 'Email cannot be empty';
        }
        if ($_POST['password1'] == '') {
          $args['password1_error'] = 'Password cannot be empty';
        }
        if ($_POST['password2'] == '') {
          $args['password2_error'] = 'Type the password again to confirm';
        }
        if ($_POST['password1'] != $_POST['password2']) {
          $args['password2_error'] = 'Passwords dont match';
        }
        if (strpbrk($_POST['first_name'], $illegal)) {
          $args['first_name_error'] = 'Name cannot contain special characters';
        }
        if (strpbrk($_POST['last_name'], $illegal)) {
          $args['last_name_error'] = 'Name cannot contain special characters';
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
          $args['email_error'] = 'Invalid email';
        }
        if (!preg_match("/^[a-z]+[a-z0-9]+[_]*[a-z0-9]+$/", $_POST['username'], $match)) {
          $args['username_error'] = 'Invalid username. No uppercase letters and has to start with a letter. Underscore is allowed. Must contain atleast three characters';
        }
        if ($_POST['username']!= '' && !User::checkUserName($_POST['username'])) {
            $args['username_error'] = 'Username already exists';
        }
        if ($_POST['email'] != '') {
          if (!User::checkEmail($_POST['email'])) {
            $args['email_error'] = 'Email already exists';
          }
        }
      }
      else if (strpbrk($_POST['first_name'], $illegal)) {
        $args['first_name_error'] = 'Name cannot contain special characters';
      }
      else if (strpbrk($_POST['last_name'], $illegal)) {
        $args['last_name_error'] = 'Name cannot contain special characters';
      }
      else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $args['email_error'] = 'Invalid email';
      }
      else if (!preg_match("/^[a-z]+[a-z0-9]+[_]*[a-z0-9]+$/", $_POST['username'], $match)) {
        $args['username_error'] = 'Invalid username. No uppercase letters. Has to start with a letter. Underscore is allowed. Must contain atleast three characters';
      }
      else if ($_POST['email'] != '' && !User::checkEmail($_POST['email'])) {
        $args['email_error'] = 'Email already exists';
      }
      else if ($_POST['username'] != '' && !User::checkUserName($_POST['username'])) {
        $args['username_error'] = 'Username already exists';
      }
      else if ($_POST['password1'] != $_POST['password2']) {
        $args['password2_error'] = 'Passwords dont match';
      }
      else {
        User::registerUser(
          $_POST['first_name'],
          $_POST['last_name'],
          $_POST['username'],
          $_POST['email'],
          $_POST['password1']
        );
        header("LOCATION: http://localhost/posts/allPosts");
        return;
      }
    }
    View::renderTemplate('Users/register.html', $args);
  }

  public function login() {
    $args = [
      'email_error' => '',
      'password_error' => '',
      'login_error' => ''
    ];
    if (isset($_POST['submit'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];
      $args['email'] = $email;
      $args['password'] = $password;
      if ($email == '' || $password == '') {
        if ($email == '') {
          $args['email_error'] = 'Email cannot be empty';
        }
        if ($password == '') {
          $args['password_error'] = 'Password cannot be empty';
        }
        // $args['login_error'] = 'Username or password does not match';
      }
      else if ($_POST['email'] != '' && User::checkEmail($_POST['email'])) {
        $args['email_error'] = 'This email does not have an account';
      }
      else {
        if(!User::loginUser($email, $password)) {
          $args['login_error'] = 'Username of password was incorrect';
        }
        else {
          header("LOCATION: http://localhost/posts/allPosts");
        }
      }
    }
    View::renderTemplate('Users/login.html', $args);
  }

  public function logout() {
    $_SESSION['username'] = '';
    $_SESSION['email'] = '';
    $_SESSION['password'] = '';
    $_SESSION['user_is_authenticated'] = false;
    header("LOCATION: http://localhost/users/login");
  }
}
