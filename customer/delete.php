<?php

require_once __DIR__ . '/../bootstrap.php';

$result = $db->query("DELETE FROM `customer` WHERE `id`='" . (int)$_REQUEST['customer_id'] . "'");

redirect('/customer/browse.php');

?>