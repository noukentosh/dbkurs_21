<?php

require_once __DIR__ . '/../bootstrap.php';

$breadcrumbs = [
  ['href' => '/service/browse.php', 'title' => "Услуги"],
  ['title' => "Все услуги"]
];

$result = $db->query("SELECT * FROM `service`");

$items = $result->fetch_all(MYSQLI_ASSOC);

$result = $db->query("SELECT `id`, `title` FROM `category`");

$categories = [];

foreach ($result->fetch_all(MYSQLI_ASSOC) as $category) {
  $categories[$category['id']] = $category['title'];
}

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Услуги</span>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Добавить</button>
</div>

<?php if (count($items) !== 0): ?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Название</th>
      <th scope="col">Категория</th>
      <th scope="col">Стоимость</th>
      <th scope="col">Действие</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
      <th scope="row"><?= $item['id'] ?></th>
      <td><?= $item['title'] ?></td>
      <td><?= editLink ('category', 'id', $item['category_id'], 'title') ?></td>
      <td><?= $item['cost'] ?> ₽</td>
      <td><a href="/service/edit.php?service_id=<?= $item['id'] ?>">Изменить</a></td>
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

<?php introModalAdd('modalAdd', 'Добавить услугу', '/service/add.php') ?>
  <div class="mb-3">
    <?php fieldRel ('category_id', 'Категория', '', $categories) ?>
  </div>
  <div class="mb-3">
    <?php field ('title', 'Название') ?>
  </div>
  <div class="mb-3">
    <?php field ('cost', 'Стоимость') ?>
  </div>
<?php outroModalAdd() ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>