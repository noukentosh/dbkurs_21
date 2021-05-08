<?php

require_once __DIR__ . '/../bootstrap.php';

$breadcrumbs = [
  ['href' => '/category/browse.php', 'title' => "Категории"],
  ['title' => "Все категории"]
];

$result = $db->query("SELECT * FROM `category`");

$items = $result->fetch_all(MYSQLI_ASSOC);

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Категории</span>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Добавить</button>
</div>

<?php if (count($items) !== 0): ?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Название</th>
      <th scope="col">Действие</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
    <tr>
      <th scope="row"><?= $item['id'] ?></th>
      <td><?= $item['title'] ?></td>
      <td><a href="/category/edit.php?category_id=<?= $item['id'] ?>">Изменить</a></td>
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

<?php introModalAdd('modalAdd', 'Добавить категорию', '/category/add.php') ?>
  <div class="mb-3">
    <?php field ('title', 'Название') ?>
  </div>
<?php outroModalAdd() ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>