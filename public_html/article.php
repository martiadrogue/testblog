<?php

use dev\martiadrogue\omega\CrudArticles;

require_once 'init.php';

if ($_GET['id']) {
  $db = new CrudArticles();
  $article = $db->read($_GET['id']);

  if ($article) {
    $loader = new Twig_Loader_Filesystem('templates');
    $twig = new Twig_Environment($loader);
    echo $twig->render('article.html', array('article' => $article));
  } else {
    header('HTTP/1.0 404 Not Found');
    echo $twig->render('404.html');
  }
}
