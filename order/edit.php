<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $db->query("SELECT SUM(`cost`) as `total` FROM `service` WHERE `id` IN ('" . implode("', '", array_map('intval', $_POST['services'])) . "')");

  $total = $result->fetch_assoc();

  $total = $total['total'];

  $db->query("UPDATE `order` SET `employee_id`='" . (int)$_POST['employee_id'] . "', `customer_id`='" . (int)$_POST['customer_id'] . "', `car_id`='" . (int)$_POST['car_id'] . "', `total`='" . (float)$total . "', `comment`='" . $db->real_escape_string($_POST['comment']) . "', `status`='" . $db->real_escape_string($_POST['status']) . "' WHERE `id`='" . (int)$_REQUEST['order_id'] . "'");

  $db->query("DELETE FROM `order_service` WHERE `order_id`='" . (int)$_REQUEST['order_id'] . "'");

  foreach (array_map('intval', $_POST['services']) as $service_id) {
    $db->query("INSERT INTO `order_service` (`order_id`, `service_id`) VALUES ('" . (int)$_REQUEST['order_id'] . "', '" . $service_id . "')");
  }

  redirect('/order/browse.php');
}

$breadcrumbs = [
  ['href' => '/order/browse.php', 'title' => "Заказы"],
  ['title' => "Редактирование заказа"]
];

$result = $db->query("SELECT * FROM `order` WHERE `id`='" . (int)$_REQUEST['order_id'] . "'");

$item = $result->fetch_assoc();

$result = $db->query("SELECT `service_id` FROM `order_service` WHERE `order_id`='" . (int)$_REQUEST['order_id'] . "'");

$item['services'] = array_map('current', $result->fetch_all(MYSQLI_NUM));

$employees = getList ('employee', 'id', 'full_name');
$customers = getList ('customer', 'id', 'full_name');
$cars = getList ('car', 'id', 'license_plate');
$employees = getList ('employee', 'id', 'full_name');
$services = getList ('service', 'id', ['title', 'cost'], '#title# - #cost# ₽');

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Редактирование заказа</span>
</div>

<form method="POST" action="/order/edit.php?order_id=<?= $item['id'] ?>" class="row align-items-start">
  <div class="col-9">
    <div class="row">
      <div class="col">
        <div class="mb-3">
          <?php fieldRel ('employee_id', 'Работник', $item['employee_id'], $employees) ?>
        </div>
        <div class="mb-3">
          <?php fieldRel ('customer_id', 'Клиент', $item['customer_id'], $customers) ?>
        </div>
        <div class="mb-3">
          <?php fieldRel ('car_id', 'Автомобиль', $item['car_id'], $cars) ?>
        </div>
        <div class="mb-3">
          <?php field ('comment', 'Комментарий', $item['comment']) ?>
        </div>
      </div>
      <div class="col">
        <div class="mb-3">
          <?php fieldRel ('services', 'Услуги', $item['services'], $services, true) ?>
        </div>
        <div class="mb-3">
          <?php fieldRel ('status', 'Статус', $item['status'], [
            'processing' => "В работе",
            'canceled' => "Отмена",
            'complete' => "Выполнено"
          ]) ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="card">
      <div class="card-header">
        Информация
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">ID: <?= $item['id'] ?></li>
        <li class="list-group-item">
          <button type="submit" class="btn btn-primary">Сохранить</button>
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">Удалить</button>
        </li>
      </ul>
    </div>
  </div>
</form>

<?php modalDelete('modalDelete', 'Удалить заказ', '/order/delete.php?order_id=' . $item['id']) ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>