<?php

require_once __DIR__ . '/../bootstrap.php';

$result = $db->query("DELETE FROM `service` WHERE `id`='" . (int)$_REQUEST['service_id'] . "'");

redirect('/service/browse.php');

?>