<?php

require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $result = $db->query("SELECT SUM(`cost`) as `total` FROM `service` WHERE `id` IN ('" . implode("', '", array_map('intval', $_POST['services'])) . "')");

  $total = $result->fetch_assoc();

  $total = $total['total'];

  $db->query("UPDATE `order` SET `employee_id`='" . (int)$_POST['employee_id'] . "', `customer_id`='" . (int)$_POST['customer_id'] . "', `car_id`='" . (int)$_POST['car_id'] . "', `total`='" . (float)$total . "', `comment`='" . $db->real_escape_string($_POST['comment']) . "', `status`='" . $db->real_escape_string($_POST['status']) . "' WHERE `id`='" . (int)$_REQUEST['order_id'] . "'");

  $db->query("DELETE FROM `order_service` WHERE `order_id`='" . (int)$_REQUEST['order_id'] . "'");

  foreach (array_map('intval', $_POST['services']) as $service_id) {
    $db->query("INSERT INTO `order_service` (`order_id`, `service_id`) VALUES ('" . (int)$_REQUEST['order_id'] . "', '" . $service_id . "')");
  }

  redirect('/order/browse.php');
}

$breadcrumbs = [
  ['href' => '/order/browse.php', 'title' => "Заказы"],
  ['title' => "Редактирование заказа"]
];

$result = $db->query("SELECT * FROM `order` WHERE `id`='" . (int)$_REQUEST['order_id'] . "'");

$item = $result->fetch_assoc();

$result = $db->query("SELECT `service_id` FROM `order_service` WHERE `order_id`='" . (int)$_REQUEST['order_id'] . "'");

$item['services'] = array_map('current', $result->fetch_all(MYSQLI_NUM));

$employees = getTable ('employee');
$employee_category = getTable ('employee_category');
$customers = getTable ('customer');
$cars = getTable ('car');
$services = getTable ('service');

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Редактирование заказа</span>
</div>

<form method="POST" action="/order/edit.php?order_id=<?= $item['id'] ?>" class="row align-items-start">
  <div class="col-9">
    <div id="modalAddForm">
      <div class="row">
        <div class="col">
          <div class="mb-3">
            <label for="input-employee_id" class="form-label">Работник</label> 
            <select id="input-employee_id" name="employee_id" class="form-select" v-model="selected_employee">
              <option v-for="item in employee_values" :value="item.id">{{ item.full_name }}</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="input-customer_id" class="form-label">Клиент</label> 
            <select id="input-customer_id" name="customer_id" class="form-select" v-model="selected_customer">
              <option v-for="item in customer_values" :value="item.id">{{ item.full_name }}</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="input-car_id" class="form-label">Автомобиль</label> 
            <select id="input-car_id" name="car_id" class="form-select" v-model="selected_car">
              <option v-for="item in availableCars" :value="item.id">{{ item.license_plate }}</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="input-comment" class="form-label">Комментарий</label>
            <input type="text" id="input-comment" name="comment" class="form-control" v-model="selected_comment">
          </div>
        </div>
        <div class="col">
          <div class="mb-3">
            <label for="input-services" class="form-label">Услуги</label> 
            <select multiple="multiple" id="input-services" name="services[]" class="form-select" size="9" v-model="selected_service">
              <option v-for="item in availableServices" :value="item.id">{{ item.title }} - {{ item.cost }} ₽</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="input-status" class="form-label">Статус</label> 
            <select id="input-status" name="status" class="form-select" v-model="selected_status">
              <option value="processing" selected="selected">В работе</option>
              <option value="canceled">Отмена</option>
              <option value="complete">Выполнено</option>
            </select>
          </div>
        </div>
      </div>
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

<?php modalDelete('modalDelete', 'Удалить заказ', '/order/delete.php?order_id=' . $item['id']) ?>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
  var modalAddForm = new Vue({
    el: '#modalAddForm',
    data: {
      employee_values: <?= json_encode($employees) ?>,
      employee_category: <?= json_encode($employee_category) ?>,
      customer_values: <?= json_encode($customers) ?>,
      car_values: <?= json_encode($cars) ?>,
      service_values: <?= json_encode($services) ?>,
      selected_employee: '<?= $item['employee_id'] ?>',
      selected_customer: '<?= $item['customer_id'] ?>',
      selected_car: '<?= $item['car_id'] ?>',
      selected_comment: '<?= $item['comment'] ?>',
      selected_service: <?= json_encode($item['services']) ?>,
      selected_status: '<?= $item['status'] ?>'
    },
    computed: {
      availableCategories () {
        let table = this.employee_category.filter(item => this.selected_employee === item.employee_id);

        return table.map(item => item.category_id);
      },
      availableServices () {
        return this.service_values.filter(item => this.availableCategories.includes(item.category_id))
      },
      availableCars () {
        return this.car_values.filter(item => this.selected_customer === item.customer_id);
      }
    }
  })
</script>

<?php require_once __DIR__ . '/../inc/footer.php'; ?>