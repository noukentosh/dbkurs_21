<?php

require_once __DIR__ . '/../bootstrap.php';

$db->query("INSERT INTO `employee` (`full_name`) VALUES ('" . $db->real_escape_string($_POST['full_name']) . "')");

$employee_id = $db->insert_id;

$db->query("DELETE FROM `employee_category` WHERE `employee_id`='" . $employee_id . "'");

foreach (array_map('intval', $_POST['categories']) as $category) {
  $db->query("INSERT INTO `employee_category` (`employee_id`, `category_id`) VALUES ('" . $employee_id . "', '" . $category . "')");
}

redirect('/employee/browse.php');

?>