<div class="form-group">
  <?php if ($label): ?>
    <label class="form-label" for="<?= 'field_'.$name ?>">
      <?= ucfirst($label) ?>
      <?php $this->load->view('partials/field_name', ['name' => $name]) ?>
    </label>
  <?php endif ?>
  <span class="ldb-required"><?= ($required ? '*' : '') ?></span>
  <textarea
    id="<?= 'field_'.$name ?>"
    rows="5"
    class="form-control"
    name="<?= $name ?>"
    <?= ($autofocus ? 'autofocus' : '') ?>
    <?php if ($help): ?>
      placeholder="<?= ucfirst($help) ?>"
    <?php endif; ?>
    <?= $disabled ? 'disabled="true"' : '' ?>
  ><?= set_value($name, $value) ?></textarea>
</div>