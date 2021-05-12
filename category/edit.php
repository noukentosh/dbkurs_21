<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db->query("UPDATE `category` SET `title`='" . $db->real_escape_string($_POST['title']) . "' WHERE `id`='" . (int)$_REQUEST['category_id'] . "'");
  redirect('/category/browse.php');
}

$breadcrumbs = [
  ['href' => '/category/browse.php', 'title' => "Категории"],
  ['title' => "Редактирование категории"]
];

$result = $db->query("SELECT * FROM `category` WHERE `id`='" . (int)$_REQUEST['category_id'] . "'");

$item = $result->fetch_assoc();

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Редактирование категории</span>
</div>

<form method="POST" action="/category/edit.php?category_id=<?= $item['id'] ?>" class="row align-items-start">
  <div class="col-9">
    <div class="mb-3">
      <?php field ('title', 'Название', $item['title']) ?>
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

<?php modalDelete('modalDelete', 'Удалить категорию', '/category/delete.php?category_id=' . $item['id']) ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>