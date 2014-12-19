<?php

use dev\martiadrogue\omega\CrudArticles;

require_once 'init.php';

// guardar a les cookies la pàgina on l'usuari ha intentat entrar sense
// autentificació.
// SPL: mirar iteradors arrayobject, recursivedirectoryiterator, recursiveiteratoriterator classes per classificar fifo, etc, exceptions
// https://github.com/squizlabs/PHP_CodeSniffer
// logger
// https://github.com/FriendsOfPHP/PHP-CS-Fixer
//
// https://github.com/symfony/HttpKernel
// https://github.com/symfony/HttpFoundation
// libreria mysql. doctrine

$db = new CrudArticles();
$articles = $db->read();

echo $twig->render('index.html', array('articles' => $articles, 'action' => 'article.php'));
