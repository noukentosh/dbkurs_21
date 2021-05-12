<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db->query("UPDATE `car` SET `customer_id`='" . (int)$_POST['customer_id'] . "', `vin`='" . $db->real_escape_string($_POST['vin']) . "', `license_plate`='" . $db->real_escape_string($_POST['license_plate']) . "', `model`='" . $db->real_escape_string($_POST['model']) . "' WHERE `id`='" . (int)$_REQUEST['car_id'] . "'");
  
  redirect('/car/browse.php');
}

$breadcrumbs = [
  ['href' => '/car/browse.php', 'title' => "Автомобили"],
  ['title' => "Редактирование автомобиля"]
];

$result = $db->query("SELECT * FROM `car` WHERE `id`='" . (int)$_REQUEST['car_id'] . "'");

$item = $result->fetch_assoc();

$result = $db->query("SELECT `id`, `full_name` FROM `customer`");

$customers = [];

foreach ($result->fetch_all(MYSQLI_ASSOC) as $customer) {
  $customers[$customer['id']] = $customer['full_name'];
}

$result = $db->query("SELECT s.`id`, s.`title`, s.`cost` FROM `service` as s INNER JOIN `order_service` as os ON s.`id` = os.`service_id` INNER JOIN `order` as o ON o.`id` = os.`order_id` WHERE o.`car_id`='" . (int)$_REQUEST['car_id'] . "'");

$services = $result->fetch_all(MYSQLI_ASSOC);

$total = array_sum(array_column($services, 'cost'));

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Редактирование автомобиля</span>
</div>

<form method="POST" action="/car/edit.php?car_id=<?= $item['id'] ?>" class="row align-items-start">
  <div class="col-5">
    <div class="mb-3">
      <?php fieldRel ('customer_id', 'Клиент', $item['customer_id'], $customers) ?>
    </div>
    <div class="mb-3">
      <?php field ('vin', 'VIN', $item['vin']) ?>
    </div>
    <div class="mb-3">
      <?php field ('license_plate', 'Номер авто', $item['license_plate']) ?>
    </div>
    <div class="mb-3">
      <?php field ('model', 'Модель', $item['model']) ?>
    </div>
  </div>
  <div class="col-4">
    <div class="h4 mb-3">Оказываемые услуги</div>
    <ul class="list-group">
      <?php foreach ($services as $service): ?>
      <li class="list-group-item"><?= editLink ('service', 'id', $service['id'], 'title') ?></li>
      <?php endforeach ?>
      <li class="list-group-item">Всего: <?= $total ?> ₽</li>
    </ul>
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

<?php modalDelete('modalDelete', 'Удалить автомобиль', '/car/delete.php?car_id=' . $item['id']) ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>