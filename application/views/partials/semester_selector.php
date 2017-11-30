<div class="form-group">
  <?php if ($label): ?>
    <label class="form-label" for="<?= 'field_'.$name ?>">
      <?= ucfirst($label) ?>
    </label>
  <?php endif ?>
  <span class="ldb-required"><?= ($required ? '*' : '') ?></span>
  <select
    id="<?= 'field_'.$name ?>"
    class="form-control"
    name="<?= $name ?>"
  >
    <option></option>
    <?php foreach ($semesters as $semester): ?>
      <option
        value="<?= $semester ?>"
        <?= set_select($name, $semester, $semester == $value) ?>
      >
        <?= $semester ?>
      </option>
    <?php endforeach; ?>
  </select>
</div>