<?php

require 'parameters.php';

session_start();

function __autoload($classname)
{
  require_once 'classes/class.' . $classname . '.php';
}

try {
  $db = new PDO('mysql:hostname=' . HOST . '; dbname=' . DATABASE . '; charset=utf8;', USER, PASSWORD);
} catch (PDOException $e) {
  die($e->getMessage());
}
