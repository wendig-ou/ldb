<div class="form-group">
  <?php if ($label): ?>
    <label class="form-label" for="field_type_id">
      <?= ucfirst($label) ?>
    </label>
    <span class="ldb-required">*</span>
  <?php endif; ?>
  
  <?php foreach ($types as $type): ?>
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