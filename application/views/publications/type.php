<?php if (sizeof($types) > 1): ?>
  <div class="d-flex flex-column flex-row-md">
    <div class="flex-col-md-5">
      <?= type_selector('klr_tow', [
        'value' => $publication['klr_tow'],
        'variant' => 'radios'
      ]); ?>
    </div>

    <div class="flex-col-md-7">
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