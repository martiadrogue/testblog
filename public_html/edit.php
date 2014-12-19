<?php

use dev\martiadrogue\omega\CrudArticles;

require_once 'init.php';
require_once 'auth.php';

if ($_GET['id']) {
  $db = new CrudArticles();
  $article = $db->read($_GET['id']);
  if ($article) {
    echo $twig->render('fields.html', array('article' => $article, 'session' => PHP_SESSION_ACTIVE));
  } else {
    header('HTTP/1.0 404 Not Found');
    echo $twig->render('404.html');
  }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email = $_POST['author'];
  if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    $db = new CrudArticles();
    $db->update($_POST['id'], $_POST['title'], $_POST['author'], $_POST['content'], $_POST['tags'], $_POST['created_at']);

    $host  = $_SERVER['HTTP_HOST'];
    header("Location: http://$host/article.php?id={$_POST['id']}");
    die();
  }else{
    $error ="email malformed";
    echo $twig->render('fields.html', array('error' => $error, 'action' => 'create.php', 'session' => PHP_SESSION_ACTIVE ));
  }
}
