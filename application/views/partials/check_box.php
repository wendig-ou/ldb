<div class="form-group checkbox">
  <label class="form-label">
    <input
      type="checkbox"
      name="<?= $name ?>"
      value="1"
      <?= $disabled ? 'disabled="true"' : '' ?>
      <?= set_checkbox($name, '1', !!$value) ?>
    />
    <?= ucfirst($label) ?>
  </label>
</div>