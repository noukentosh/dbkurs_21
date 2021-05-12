<?php

require_once __DIR__ . '/../bootstrap.php';

$result = $db->query("SELECT SUM(`cost`) as `total` FROM `service` WHERE `id` IN ('" . implode("', '", array_map('intval', $_POST['services'])) . "')");

$total = $result->fetch_assoc();

$total = $total['total'];

$db->query("INSERT INTO `order` (`employee_id`, `customer_id`, `car_id`, `total`, `comment`, `status`) VALUES ('" . (int)$_POST['employee_id'] . "', '" . (int)$_POST['customer_id'] . "', '" . (int)$_POST['car_id'] . "', '" . $total . "', '" . $db->real_escape_string($_POST['comment']) . "', '" . $db->real_escape_string($_POST['status']) . "')");

$order_id = $db->insert_id;

foreach (array_map('intval', $_POST['services']) as $service_id) {
  $db->query("INSERT INTO `order_service` (`order_id`, `service_id`) VALUES ('" . $order_id . "', '" . $service_id . "')");
}

redirect('/order/browse.php');


?>