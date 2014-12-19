<?php

use dev\martiadrogue\omega\CrudUsers;
use dev\martiadrogue\omega\PasswordHash;

require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $db = new CrudUsers();
  $user = $db->read($username);

  $secure = new PasswordHash();
  if ($secure->validate_password($password, $user['password'])) {
    $_SESSION['username'] = $username;

    $host = $_SERVER['HTTP_HOST'];
    header("Location: http://$host/");
    die();
  }

}

echo $twig->render('login.html');
