<?php

require_once __DIR__ . '/../bootstrap.php';

$result = $db->query("DELETE FROM `order` WHERE `id`='" . (int)$_REQUEST['order_id'] . "'");

redirect('/order/browse.php');

?>