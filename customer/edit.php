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

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Редактирование клиента</span>
</div>

<div class="row align-items-start">
  <div class="col-9">
    <form method="POST" action="/customer/edit.php?customer_id=<?= $item['id'] ?>">
      <div class="mb-3">
        <?php field ('full_name', 'ФИО', $item['full_name']) ?>
      </div>
    </form>
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
</div>

<?php modalDelete('modalDelete', 'Удалить клиента', '/customer/delete.php?customer_id=' . $item['id']) ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>