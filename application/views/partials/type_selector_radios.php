<div class="form-group">
  <?php if ($label): ?>
    <label class="form-label" for="field_type_id">
      <?= ucfirst($label) ?>
    </label>
    <span class="ldb-required">*</span>
  <?php endif; ?>

  <?php foreach ($types as $type): ?>
    <?php if (in_array($type['tow'], ['09.10', '09.11', '09.12', '09.13', '09.14', '09.15', '09.16'])) {
      if (!has_role(['library', 'admin'])) {
        continue;
      }
    } ?>

    <div class="radio">
      <label>
        <input
          type="radio"
          name="<?= $name ?>"
          value="<?= $type['tow'] ?>"
          <?= ($autofocus ? 'autofocus' : '') ?>
          <?= set_radio('klr_tow', $type['tow'], $type['tow'] == $value) ?>
        />
        <?= $type['tow'] ?>
        -
        <?= $type['t_desc'] ?>
      </label>
    </div>
  <?php endforeach; ?>
</div>