<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db->query("UPDATE `service` SET `category_id`='" . (int)$_POST['category_id'] . "', `title`='" . $db->real_escape_string($_POST['title']) . "', `cost`='" . (float)$_POST['cost'] . "' WHERE `id`='" . (int)$_REQUEST['service_id'] . "'");

  redirect('/service/browse.php');
}

$breadcrumbs = [
  ['href' => '/service/browse.php', 'title' => "Услуги"],
  ['title' => "Редактирование услуги"]
];

$result = $db->query("SELECT * FROM `service` WHERE `id`='" . (int)$_REQUEST['service_id'] . "'");

$item = $result->fetch_assoc();

$result = $db->query("SELECT `id`, `title` FROM `category`");

$categories = [];

foreach ($result->fetch_all(MYSQLI_ASSOC) as $category) {
  $categories[$category['id']] = $category['title'];
}

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Редактирование услуги</span>
</div>

<form method="POST" action="/service/edit.php?service_id=<?= $item['id'] ?>" class="row align-items-start">
  <div class="col-9">
    <div class="mb-3">
      <?php fieldRel ('category_id', 'Категория', $item['category_id'], $categories) ?>
    </div>
    <div class="mb-3">
      <?php field ('title', 'Название', $item['title']) ?>
    </div>
    <div class="mb-3">
      <?php field ('cost', 'Стоимость', $item['cost']) ?>
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

<?php modalDelete('modalDelete', 'Удалить услугу', '/service/delete.php?service_id=' . $item['id']) ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>