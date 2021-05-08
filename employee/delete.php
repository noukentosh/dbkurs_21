<?php

require_once __DIR__ . '/../bootstrap.php';

$result = $db->query("DELETE FROM `employee` WHERE `id`='" . (int)$_REQUEST['employee_id'] . "'");

redirect('/employee/browse.php');

?>