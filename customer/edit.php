<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db->query("UPDATE `customer` SET `full_name`='" . $db->real_escape_string($_POST['full_name']) . "' WHERE `id`='" . (int)$_REQUEST['customer_id'] . "'");
  redirect('/customer/browse.php');
}

$breadcrumbs = [
  ['href' => '/customer/browse.php', 'title' => "Клиенты"],
  ['title' => "Редактирование клиента"]
];

$result = $db->query("SELECT * FROM `customer` WHERE `id`='" . (int)$_REQUEST['customer_id'] . "'");

$item = $result->fetch_assoc();

$result = $db->query("SELECT * FROM `car` WHERE `customer_id`='" . (int)$_REQUEST['customer_id'] . "'");

$cars = $result->fetch_all(MYSQLI_ASSOC);

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Редактирование клиента</span>
</div>

<form method="POST" action="/customer/edit.php?customer_id=<?= $item['id'] ?>" class="row align-items-start">
  <div class="col-5">
    <div class="mb-3">
      <?php field ('full_name', 'ФИО', $item['full_name']) ?>
    </div>
  </div>
  <div class="col-4">
    <div class="h4 mb-3">Автомобили</div>
    <ul class="list-group">
      <?php foreach ($cars as $car): ?>
      <li class="list-group-item"><?= editLink ('car', 'id', $car['id'], 'license_plate') ?></li>
      <?php endforeach ?>
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

<?php modalDelete('modalDelete', 'Удалить клиента', '/customer/delete.php?customer_id=' . $item['id']) ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>