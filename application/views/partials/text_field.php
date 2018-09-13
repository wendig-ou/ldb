<div class="form-group">
  <?php if ($label): ?>
    <label class="form-label" for="<?= 'field_'.$name ?>">
      <?= ucfirst($label) ?>
    </label>
  <?php endif ?>
  <span class="ldb-required"><?= ($required ? '*' : '') ?></span>
  <input
    id="<?= 'field_'.$name ?>"
    class="form-control"
    type="<?= $type ?>"
    name="<?= $name ?>"
    value="<?= set_value($name, $value) ?>"
    <?= ($autofocus ? 'autofocus' : '') ?>
    <?php if ($help): ?>
      placeholder="<?= ucfirst($help) ?>"
    <?php endif; ?>
    <?= $disabled ? 'disabled="true"' : '' ?>
  />
</div>