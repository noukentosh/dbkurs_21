<?php

$db = new mysqli ('127.0.0.1', 'root', 'root', 'dbkurs');

if ($db->connect_errno) {
  echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  die();
}