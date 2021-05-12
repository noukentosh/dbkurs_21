<?php

$db = new mysqli ('127.0.0.1', 'root', 'root', 'dbkurs');

if ($db->connect_errno) {
  echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
  die();
}

function getList ($table, $pk_id, $label_keys, $label_template = null) {
  global $db;

  $result = $db->query("SELECT `{$pk_id}`, `" . (is_array($label_keys) ? implode("`, `", $label_keys) : $label_keys) . "` FROM `{$table}`");

  $items = [];

  foreach ($result->fetch_all(MYSQLI_ASSOC) as $item) {
    $value = $item[$pk_id];
    
    if(is_null($label_template)) {
      if(is_array($label_keys)) {
        $label = $item[$label_keys[0]];
      } else {
        $label = $item[$label_keys];
      }
    } else {
      $label = $label_template;

      foreach ($label_keys as $label_key) {
        $label = str_replace("#{$label_key}#", $item[$label_key], $label);
      }
    }
    
    $items[$value] = $label;
  }

  return $items;
}