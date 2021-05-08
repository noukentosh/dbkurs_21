<?php

require_once __DIR__ . '/../bootstrap.php';

$breadcrumbs = [
  ['href' => '/order/browse.php', 'title' => "Заказы"],
  ['title' => "Все заказы"]
];

$result = $db->query("SELECT * FROM `order`");

$items = $result->fetch_all(MYSQLI_ASSOC);

$employees = getList ('employee', 'id', 'full_name');
$customers = getList ('customer', 'id', 'full_name');
$cars = getList ('car', 'id', 'license_plate');
$employees = getList ('employee', 'id', 'full_name');
$services = getList ('service', 'id', 'title');

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Заказы</span>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Добавить</button>
</div>

<?php if (count($items) !== 0): ?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Работник</th>
      <th scope="col">Клиент</th>
      <th scope="col">Автомобиль</th>
      <th scope="col">Создан/Обновлен</th>
      <th scope="col">Всего</th>
      <th scope="col">Действие</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
      <th scope="row"><?= $item['id'] ?></th>
      <td><?= editLink ('employee', 'id', $item['employee_id'], 'full_name') ?></td>
      <td><?= editLink ('customer', 'id', $item['customer_id'], 'full_name') ?></td>
      <td><?= editLink ('car', 'id', $item['car_id'], 'title') ?></td>
      <td><?= $item['created_on'] ?><br><?= $item['updated_on'] ?></td>
      <td><?= $item['total'] ?></td>
      <td><a href="/order/edit.php?order_id=<?= $item['id'] ?>">Изменить</a></td>
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

<?php introModalAdd('modalAdd', 'Добавить услугу', '/order/add.php', 'modal-lg') ?>
  <div class="row">
    <div class="col">
      <div class="mb-3">
        <?php fieldRel ('employee_id', 'Работник', '', $employees) ?>
      </div>
      <div class="mb-3">
        <?php fieldRel ('customer_id', 'Клиент', '', $customers) ?>
      </div>
      <div class="mb-3">
        <?php fieldRel ('car_id', 'Автомобиль', '', $cars) ?>
      </div>
      <div class="mb-3">
        <?php field ('comment', 'Комментарий') ?>
      </div>
    </div>
    <div class="col">
      <div class="mb-3">
        <?php fieldRel ('services', 'Услуги', [], $services, true) ?>
      </div>
    </div>
  </div>
<?php outroModalAdd() ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>