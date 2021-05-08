<?php

require_once __DIR__ . '/../bootstrap.php';

$breadcrumbs = [
  ['href' => '/car/browse.php', 'title' => "Автомобили"],
  ['title' => "Все автомобили"]
];

$result = $db->query("SELECT * FROM `car`");

$items = $result->fetch_all(MYSQLI_ASSOC);

$result = $db->query("SELECT `id`, `full_name` FROM `customer`");

$customers = [];

foreach ($result->fetch_all(MYSQLI_ASSOC) as $customer) {
  $customers[$customer['id']] = $customer['full_name'];
}

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Автомобили</span>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Добавить</button>
</div>

<?php if (count($items) !== 0): ?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Клиент</th>
      <th scope="col">VIN</th>
      <th scope="col">Номер авто</th>
      <th scope="col">Модель</th>
      <th scope="col">Действие</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
      <th scope="row"><?= $item['id'] ?></th>
      <td><?= editLink ('customer', 'id', $item['customer_id'], 'full_name') ?></td>
      <td><?= $item['vin'] ?></td>
      <td><?= $item['license_plate'] ?></td>
      <td><?= $item['model'] ?></td>
      <td><a href="/car/edit.php?car_id=<?= $item['id'] ?>">Изменить</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php else: ?>
<div class="card">
  <div class="card-body text-center">
    Пусто
  </div>
</div>
<?php endif; ?>

<?php introModalAdd('modalAdd', 'Добавить автомобиль', '/car/add.php') ?>
  <div class="mb-3">
    <?php fieldRel ('customer_id', 'Клиент', '', $customers) ?>
  </div>
  <div class="mb-3">
    <?php field ('vin', 'VIN') ?>
  </div>
  <div class="mb-3">
    <?php field ('license_plate', 'Номер авто') ?>
  </div>
  <div class="mb-3">
    <?php field ('model', 'Модель') ?>
  </div>
<?php outroModalAdd() ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>