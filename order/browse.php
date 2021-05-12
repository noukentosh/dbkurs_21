<?php

require_once __DIR__ . '/../bootstrap.php';

$breadcrumbs = [
  ['href' => '/order/browse.php', 'title' => "Заказы"],
  ['title' => "Все заказы"]
];

$result = $db->query("SELECT * FROM `order`");

$items = $result->fetch_all(MYSQLI_ASSOC);

$employees = getTable ('employee');
$employee_category = getTable ('employee_category');
$customers = getTable ('customer');
$cars = getTable ('car');
$services = getTable ('service');

?>

<?php require_once __DIR__ . '/../inc/header.php'; ?>

<div class="d-flex align-items-center mb-4">
  <span class="h3 me-auto">Заказы</span>
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Добавить</button>
</div>

<?php if (count($items) !== 0): ?>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Работник</th>
      <th scope="col">Клиент</th>
      <th scope="col">Автомобиль</th>
      <th scope="col">Создан</th>
      <th scope="col">Обновлен</th>
      <th scope="col">Всего</th>
      <th scope="col">Действие</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($items as $item): ?>
    <?php
      switch ($item['status']) {
        case 'processing': {
          $row_class = 'table-light';
          break;
        }
        case 'canceled': {
          $row_class = 'table-danger';
          break;
        }
        case 'complete': {
          $row_class = 'table-success';
          break;
        }
      }
    ?>
    <tr class="<?= $row_class ?>">
      <th scope="row"><?= $item['id'] ?></th>
      <td><?= editLink ('employee', 'id', $item['employee_id'], 'full_name') ?></td>
      <td><?= editLink ('customer', 'id', $item['customer_id'], 'full_name') ?></td>
      <td><?= editLink ('car', 'id', $item['car_id'], 'license_plate') ?></td>
      <td><?= date("H:i:s d/m/Y", strtotime($item['created_on'])) ?></td>
      <td><?= date("H:i:s d/m/Y", strtotime($item['updated_on'])) ?></td>
      <td><?= $item['total'] ?> ₽</td>
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

<?php introModalAdd('modalAdd', 'Добавить заказ', '/order/add.php', 'modal-lg') ?>
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
          <select id="input-car_id" name="car_id" class="form-select">
            <option v-for="item in availableCars" :value="item.id">{{ item.license_plate }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="input-comment" class="form-label">Комментарий</label>
          <input type="text" id="input-comment" name="comment" class="form-control">
        </div>
      </div>
      <div class="col">
        <div class="mb-3">
          <label for="input-services" class="form-label">Услуги</label> 
          <select multiple="multiple" id="input-services" name="services[]" class="form-select" size="9">
            <option v-for="item in availableServices" :value="item.id">{{ item.title }} - {{ item.cost }} ₽</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="input-status" class="form-label">Статус</label> 
          <select id="input-status" name="status" class="form-select">
            <option value="processing" selected="selected">В работе</option>
            <option value="canceled">Отмена</option>
            <option value="complete">Выполнено</option>
          </select>
        </div>
      </div>
    </div>
  </div>
<?php outroModalAdd() ?>

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
      selected_employee: '',
      selected_customer: ''
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