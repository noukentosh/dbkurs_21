<?php

require_once __DIR__ . '/../bootstrap.php';

$result = $db->query("DELETE FROM `category` WHERE `id`='" . (int)$_REQUEST['category_id'] . "'");

redirect('/category/browse.php');

?>