<?php function field ($name, $label, $default = '') { ?>
<label for="input-<?= $name ?>" class="form-label"><?= $label ?></label>
<input type="text" class="form-control" id="input-<?= $name ?>" name="<?= $name ?>" value="<?= $default ?>" />
<?php } ?>
<?php function introModalAdd ($id, $label, $action) { ?>
<!-- Добавление -->
<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>Label" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="<?= $action ?>">
      <div class="modal-header">
        <h5 class="modal-title" id="<?= $id ?>Label"><?= $label ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
<?php } ?>
<?php function outroModalAdd () { ?>
  </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
        <button type="submit" class="btn btn-primary">Сохранить</button>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php function modalDelete ($id, $label, $action) { ?>
<!-- Удаление -->
<div class="modal fade" id="<?= $id ?>" tabindex="-1" aria-labelledby="<?= $id ?>Label" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="<?= $action ?>">
      <div class="modal-header">
        <h5 class="modal-title" id="<?= $id ?>Label"><?= $label ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Вы уверены, что хотите удалить?
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Да</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
      </div>
    </form>
  </div>
</div>
<?php } ?>
<?php function fieldRel ($name, $label, $default = '', $options = []) { ?>
<label for="input-<?= $name ?>" class="form-label"><?= $label ?></label>
<select class="form-select" id="input-<?= $name ?>" name="<?= $name ?>">
  <?php if ($default === ''): ?>
  <option value="" disabled selected>Выберите</option>
  <?php endif ?>
  <?php foreach ($options as $key => $value): ?>
  <option value="<?= $key ?>" <?= $key == $default ? 'selected' : '' ?>><?= $value ?></option>
  <?php endforeach ?>
</select>
<?php } ?>
<?php function editLink ($table, $pk_id, $id, $label_key) { ?>
<?php 
  global $db;

  $result = $db->query("SELECT `{$label_key}` FROM `{$table}` WHERE `{$pk_id}`='{$id}'");

  $item = $result->fetch_assoc();
?>
<a href="<?= $table ?>.edit.php?<?= $table ?>_<?= $pk_id ?>=<?= $id ?>"><?= $item[$label_key] ?></a>
<?php } ?>