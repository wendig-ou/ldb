<?php if (sizeof($types) > 1): ?>
  <div class="row">
    <div class="col-md-5">
      <?= type_selector('klr_tow', [
        'value' => $publication['klr_tow'],
        'variant' => 'radios'
      ]); ?>
    </div>

    <div class="col-md-7">
      <type-details></type-details>
    </div>
  </div>

  <hr />
<?php else: ?>
  <input
    type="hidden"
    name="klr_tow"
    value="<?= $types[0]['tow'] ?>"
  />
<?php endif; ?>