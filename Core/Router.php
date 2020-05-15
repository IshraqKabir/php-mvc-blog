<?php

namespace Core;
use App\Models\User;

class Router {
  public function dispatch($url) {
    
    if ($url != '') {
      $params = explode('/', $url);
      $controller = "\App\Controllers\\" . ucfirst($params[0]);
      $instance = new $controller();
      $action = ucfirst($params[1]);
      if (count($params) == 2) {
        $instance->$action();
      }
      else if (count($params) == 3) {
        $param = $params[2];
        $instance->$action($param);
      }
      else {
        echo 'No match found';
      }
    }
    else {
      header("LOCATION: http://localhost/posts/allPosts");
    }


  }
}
