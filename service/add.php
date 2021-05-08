<?php

require_once __DIR__ . '/../bootstrap.php';

$db->query("INSERT INTO `service` (`category_id`, `title`, `cost`) VALUES ('" . (int)$_POST['category_id'] . "', '" . $db->real_escape_string($_POST['title']) . "', '" . (float)$_POST['cost'] . "')");

redirect('/service/browse.php');

?>