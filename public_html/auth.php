<?php
if (isset($_GET['logout'])) {
  $_SESSION = array();
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
}
session_destroy();
}

if (!isset($_SESSION['username'])) {
  $host = $_SERVER['HTTP_HOST'];
  $uri = '/login.php';
  header("Location: http://$host$uri/");
  die();
}
