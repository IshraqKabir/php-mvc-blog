<?php
session_start();
require '..\Core\bootstrap.php';

$url = ltrim($_SERVER['REQUEST_URI'], '/');

$router = new \Core\Router();
use App\Models\User;
if (
  !isset($_SESSION['email']) ||
  !isset($_SESSION['password']) ||
  !isset($_SESSION['username'])
) {
  $router->dispatch('users/login');
}
// find out if this else if is redundant
// and see if only checking if the session variables are set is enough
else if (!User::loginUser($_SESSION['email'], $_SESSION['password'])) {
  $router->dispatch('users/login');
}
else {
  $router->dispatch($url);
}
