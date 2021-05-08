<?php

require_once __DIR__ . '/../bootstrap.php';

$breadcrumbs = [
  ['href' => '/employee/browse.php', 'title' => "Работники"],
  ['title' => "Все работники"]
];

$result = $db->query("SELECT * FROM `employee`");

$items = $result->fetch_all(MYSQLI_ASSOC);

$result = $db->query("SELECT `id`, `title` FROM `category`");

$categories = [];

foreach ($result->fetch_all(MYSQLI_ASSOC) as $category) {
  $categories[$category['id']] = $category['title'];
}

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Работники</span>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Добавить</button>
</div>

<?php if (count($items) !== 0): ?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">ФИО</th>
      <th scope="col">Действие</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
      <th scope="row"><?= $item['id'] ?></th>
      <td><?= $item['full_name'] ?></td>
      <td><a href="/employee/edit.php?employee_id=<?= $item['id'] ?>">Изменить</a></td>
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

<?php introModalAdd('modalAdd', 'Добавить работника', '/employee/add.php') ?>
  <div class="mb-3">
    <?php field ('full_name', 'ФИО') ?>
  </div>
  <div class="mb-3">
    <?php fieldRel ('categories', 'Категории', [], $categories, true) ?>
  </div>
<?php outroModalAdd() ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>