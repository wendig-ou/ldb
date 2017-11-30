<div class="form-group">
  <?php if ($label): ?>
    <label class="form-label" for="<?= 'field_'.$name ?>">
      <?= ucfirst($label) ?>
    </label>
    <span class="ldb-required">*</span>
  <?php endif ?>
  <span class="ldb-required"><?= ($required ? '*' : '') ?></span>
  <select
    id="<?= 'field_'.$name ?>"
    class="form-control"
    name="<?= $name ?>"
  >
    <option></option>
    <?php foreach ($departments as $department): ?>
      <option
        value="<?= $department ?>"
        <?= set_select($name, $department, $department == $value) ?>
      >
        <?= $department ?>
      </option>
    <?php endforeach; ?>
  </select>
  <?php if ($help): ?>
    <span class="help-block"><?= $help ?></span>
  <?php endif; ?>
</div>