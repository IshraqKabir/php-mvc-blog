<?php

namespace Core;

class View {
  public static function renderTemplate($templatePath, $args=[]) {
    $loader = null;
    if ($loader == null) {
      $loader = new \Twig\Loader\FilesystemLoader('..' . DS . 'App' . DS . 'Views' . DS);
      $twig = new \Twig\Environment($loader, []);
      $twig->addGlobal('session', $_SESSION);
    }
    echo $twig->render($templatePath, $args);
  }
}
