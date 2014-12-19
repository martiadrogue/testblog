<?php
function examAutoloader($className) {
  $path = str_replace('\\', '/', $className);
  $filename = __DIR__ . "/src/$path.php";
  if (is_readable($filename)) {
    require_once $filename;
  }
}

spl_autoload_register('examAutoloader');
