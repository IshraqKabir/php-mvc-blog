<?php
require '..\Core\bootstrap.php';

$url = ltrim($_SERVER['REQUEST_URI'], '/');


$router = new \Core\Router();
$router->dispatch($url);
