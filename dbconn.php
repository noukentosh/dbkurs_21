<?php

$db = new mysqli ('127.0.0.1', 'root', 'root', 'dbkurs');

if ($db->connect_errno) {
  echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  die();
}

function getList ($table, $pk_id, $label_key) {
  global $db;

  $result = $db->query("SELECT `{$pk_id}`, `{$label_key}` FROM `{$table}`");

  $items = [];

  foreach ($result->fetch_all(MYSQLI_ASSOC) as $item) {
    $items[$item[$pk_id]] = $item[$label_key];
  }

  return $items;
}