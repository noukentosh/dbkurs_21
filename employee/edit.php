<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $db->query("UPDATE `employee` SET `full_name`='" . $db->real_escape_string($_POST['full_name']) . "' WHERE `id`='" . (int)$_REQUEST['employee_id'] . "'");

  $db->query("DELETE FROM `employee_category` WHERE `employee_id`='" . (int)$_REQUEST['employee_id'] . "'");

  foreach (array_map('intval', $_POST['categories']) as $category) {
    $db->query("INSERT INTO `employee_category` (`employee_id`, `category_id`) VALUES ('" . (int)$_REQUEST['employee_id'] . "', '" . $category . "')");
  }

  redirect('/employee/browse.php');
}

$breadcrumbs = [
  ['href' => '/employee/browse.php', 'title' => "Работники"],
  ['title' => "Редактирование работника"]
];

$result = $db->query("SELECT * FROM `employee` WHERE `id`='" . (int)$_REQUEST['employee_id'] . "'");

$item = $result->fetch_assoc();

$result = $db->query("SELECT `category_id` FROM `employee_category` WHERE `employee_id`='" . (int)$_REQUEST['employee_id'] . "'");

$item['categories'] = array_map('current', $result->fetch_all(MYSQLI_NUM));

$result = $db->query("SELECT `id`, `title` FROM `category`");

$categories = [];

foreach ($result->fetch_all(MYSQLI_ASSOC) as $category) {
  $categories[$category['id']] = $category['title'];
}

// Отчеты

$result = $db->query("
  SELECT
  (SELECT SUM(o.`total`) as `total` FROM `order` as o WHERE o.`employee_id`='" . (int)$_REQUEST['employee_id'] . "' AND o.`created_on` > (CURRENT_TIMESTAMP - INTERVAL 1 DAY)) as `total_day`,
  (SELECT SUM(o.`total`) as `total` FROM `order` as o WHERE o.`employee_id`='" . (int)$_REQUEST['employee_id'] . "' AND o.`created_on` > (CURRENT_TIMESTAMP - INTERVAL 1 MONTH)) as `total_month`,
  (SELECT SUM(o.`total`) as `total` FROM `order` as o WHERE o.`employee_id`='" . (int)$_REQUEST['employee_id'] . "' AND o.`created_on` > (CURRENT_TIMESTAMP - INTERVAL 3 MONTH)) as `total_quarter`,
  (SELECT SUM(o.`total`) as `total` FROM `order` as o WHERE o.`employee_id`='" . (int)$_REQUEST['employee_id'] . "' AND o.`created_on` > (CURRENT_TIMESTAMP - INTERVAL 1 YEAR)) as `total_year`
");

$totals = $result->fetch_assoc();

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Редактирование работника</span>
</div>

<form method="POST" action="/employee/edit.php?employee_id=<?= $item['id'] ?>" class="row align-items-start">
  <div class="col-6">
    <div class="mb-3">
      <?php field ('full_name', 'ФИО', $item['full_name']) ?>
    </div>
    <div class="mb-3">
      <?php fieldRel ('categories', 'Категории', $item['categories'], $categories, true) ?>
    </div>
  </div>
  <div class="col-3">
    <div class="h4 mb-3">Отчеты</div>
    <ul class="list-group">
      <li class="list-group-item">За день: <?= $totals['total_day'] ?> ₽</li>
      <li class="list-group-item">За месяц: <?= $totals['total_month'] ?> ₽</li>
      <li class="list-group-item">За квартал: <?= $totals['total_quarter'] ?> ₽</li>
      <li class="list-group-item">За год: <?= $totals['total_year'] ?>₽</li>
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

<?php modalDelete('modalDelete', 'Удалить работника', '/employee/delete.php?employee_id=' . $item['id']) ?>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>