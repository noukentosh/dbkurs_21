<?php

require_once __DIR__ . '/../bootstrap.php';

$db->query("INSERT INTO `category` (`title`) VALUES ('" . $db->real_escape_string($_POST['title']) . "')");

redirect('/category/browse.php');

?>