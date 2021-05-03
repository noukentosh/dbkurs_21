<?php

require_once __DIR__ . '/bootstrap.php';

$db->query("INSERT INTO `customer` (`full_name`) VALUES ('" . $db->real_escape_string($_POST['full_name']) . "')");

redirect('/customer.browse.php');

?>