<div class="row">
  <div class="col-md-3">

    <departments-selector
      label="igb_field_dpmts"
      departments="<?= implode(',', $departments) ?>"
      value="<?= set_value('dpmt', $publication['dpmt']) ?>"
    ></departments-selector>

    <?= text_field('fdate', [
      'label' => 'igb_field_comm_fdate', 
      'value' => $publication['fdate'],
      'required' => TRUE
    ]); ?>

    <end-year
      name="end_fdate"
      label="<?= ucfirst(lang('igb_field_comm_end_fdate')) ?>"
      value="<?= set_value('end_fdate', $publication['end_fdate']) ?>"
    ></end-year>

    <?= check_box('ct', [
      'label' => 'igb_field_ct', 
      'value' => $publication['ct'],
      'disabled' => !can_verify($current_user, $publication)
    ]); ?>

  </div>
  <div class="col-md-6">

    <?= text_area('title', [
      'label' => 'igb_field_comm_title', 
      'help' => 'igb_help_comm_title',
      'value' => $publication['title'],
      'autofocus' => TRUE,
      'required' => TRUE
    ]); ?>

    <?= text_field('notes', [
      'label' => 'igb_field_comm_notes',
      'help' => 'igb_help_comm_notes',
      'value' => $publication['notes'],
      'required' => TRUE
    ]); ?>

    <?= check_box('eu_comm', [
      'label' => 'igb_field_comm_eu_comm', 
      'value' => $publication['eu_comm']
    ]); ?>

  </div>
  <div class="col-md-3">

    <people-editor
      label="<?= ucfirst(lang('igb_field_comm_people')) ?>"
      name="people"
      value="<?= html_escape($people) ?>"
    ></people-editor>

    <?php if (has_role(['admin', 'library'])): ?>
      <?= text_area('authors', [
        'label' => 'igb_legacy_people',
        'value' => $publication['authors'],
        'disabled' => TRUE
      ]); ?>
    <?php else: ?>
      <?php if (isset($publication['authors']) && $publication['authors'] != ''): ?>
        <div class="text-muted">
          <strong><?= lang('igb_legacy_people') ?>:</strong>
          <?= author_list($publication['authors']) ?>
        </div>
      <?php endif; ?>
    <?php endif ?>

    <?= text_field('editors', [
      'label' => 'igb_involved_people',
      'value' => $publication['editors'],
      'disabled' => !has_role(['admin', 'library'])
    ]); ?>
    
  </div>

</div>
