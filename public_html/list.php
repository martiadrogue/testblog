<?php

use dev\martiadrogue\omega\CrudArticles;

require_once 'init.php';
require_once 'auth.php';

$db = new CrudArticles();
$articles = $db->read();

echo $twig->render('index.html', array('articles' => $articles, 'action' => 'edit.php', 'session' => PHP_SESSION_ACTIVE));
