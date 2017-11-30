<div class="form-group">
  <?php if (sizeof($types) > 1): ?>
    <?php if ($label): ?>
      <label class="form-label" for="field_type_id">
        <?= ucfirst($label) ?>
      </label>
      <span class="ldb-required">*</span>
    <?php endif; ?>
    <select
      id="field_type_id"
      class="form-control"
      name="<?= $name ?>"
      <?= ($autofocus ? 'autofocus' : '') ?>
    >
      <option></option>
      <?php foreach ($types as $type): ?>
        <option
          value="<?= $type['tow'] ?>"
          <?= set_select('type_id', $type['tow'], $type['tow'] == $value) ?>
        >
          <?= $type['tow'] ?>:
          <?= $type['t_desc'] ?>
        </option>
      <?php endforeach; ?>
    </select>
    <?php if ($help): ?>
      <span class="help-block"><?= ucfirst($help) ?></span>
    <?php endif; ?>
  <?php else: ?>
    <label class="form-label" for="field_type_id">
      <?= ucfirst($label) ?>:
    </label>
    <p class="form-control-static">
      <?= $types[0]['tow'] ?>:
      <?= $types[0]['t_desc'] ?>
    </p>
    <input
      type="hidden"
      name="<?= $name ?>"
      value="<?= $types[0]['tow'] ?>"
    />
  <?php endif; ?>
</div>