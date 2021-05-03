<?php

require_once __DIR__ . '/bootstrap.php';

$result = $db->query("DELETE FROM `car` WHERE `id`='" . (int)$_REQUEST['car_id'] . "'");

redirect('/car.browse.php');

?>