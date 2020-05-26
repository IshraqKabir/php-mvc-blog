<?php
session_start();
require '..\Core\bootstrap.php';

$url = $_SERVER['REQUEST_URI'];
if (strpos($_SERVER['REQUEST_URI'], 'mvc-blog/public') !== false) {
    $url = ltrim($url, 'public');
}
$url = ltrim($url, '/');
$router = new \Core\Router();
use App\Models\User;
if ($url == 'users/register') {
  $router->dispatch($url);
}
else if (!isset($_SESSION['user_is_authenticated'])
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
