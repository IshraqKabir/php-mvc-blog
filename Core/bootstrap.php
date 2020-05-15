<?php

define("ROOT", dirname(__DIR__));
define("DS", DIRECTORY_SEPARATOR);

spl_autoload_register(function ($class) {
  $file = ROOT . DS . str_replace('\\', DS, $class) . '.php';
  if (is_readable($file)) {
    require ROOT . DS . str_replace('\\', DS, $class) . '.php';
  }
});

require_once '..' . DS . 'vendor' . DS. 'autoload.php';
