<?php
require_once '../vendor/autoload.php';
require_once 'autoload.php';

session_start();
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
date_default_timezone_set('Europe/Paris');

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);
