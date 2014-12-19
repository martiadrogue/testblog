<?php

use dev\martiadrogue\omega\CrudArticles;

require_once 'init.php';
require_once 'auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $email = $_POST['author'];
  // filter_input per superglobal
  // guardar el temps actual
  if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    $db = new CrudArticles();
    $db->create($_POST['title'], $_POST['author'], $_POST['content'], $_POST['tags'], $_POST['created_at']);

    $host  = $_SERVER['HTTP_HOST'];
    $id = $db->getListIncertId();
    header("Location: http://$host/article.php?id=$id");
    die();
  }else{
    $error ="email malformed";
    echo $twig->render('fields.html', array('error' => $error, 'action' => 'create.php', 'session' => PHP_SESSION_ACTIVE ));
  }
}

echo $twig->render('fields.html', array('action' => 'create.php', 'session' => PHP_SESSION_ACTIVE ));
