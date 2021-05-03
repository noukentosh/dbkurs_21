<?php

require_once __DIR__ . '/bootstrap.php';

$db->query("INSERT INTO `car` (`customer_id`, `vin`, `license_plate`, `model`) VALUES ('" . (int)$_POST['customer_id'] . "', '" . $db->real_escape_string($_POST['vin']) . "', '" . $db->real_escape_string($_POST['license_plate']) . "', '" . $db->real_escape_string($_POST['model']) . "')");

redirect('/car.browse.php');

?>